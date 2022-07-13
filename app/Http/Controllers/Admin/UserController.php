<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 10;
        $order_col = 'user_id';
        $order_asc = 'desc';
        $keyword = $request->get('keyword');

        $query = User::where('type', 'member');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
                $q->orWhere('type', 'like', "%{$keyword}%");
            });
        }


        $users = $query->paginate($per_page);

        return view('admin.pages.users.index', [
            'users' => $users,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.pages.users.form', [
            'user' => new User,
            'title' => 'Tambah User',
        ]);
    }

    public function store(Request $request)
    {
        $user = new User;
        $request->password = bcrypt($request->password);
        $this->save($user, $request);

        return redirect()
            ->route('admin::users.index')
            ->with('info', "User '{$user->name}' berhasil ditambahkan.");
    }

    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return view('admin.pages.users.show', [
            'user' => $user
        ]);
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return view('admin.pages.users.form', [
            'user' => $user,
            'title' => "Edit User",
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->password != null) {
            $request->password = bcrypt($request->password);
            $this->save($user, $request);
        } else {
            $this->save($user, $request);
        }

        return redirect()
            ->route('admin::users.index')
            ->withInfo("Users {$users->name} berhasil di update.");
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()
            ->withInfo("User {$user->name} telah dihapus.");
    }

    public function save(user $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->type = $request->get('type');
        $user->save();
    }
}
