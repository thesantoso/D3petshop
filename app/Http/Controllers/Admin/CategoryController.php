<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 10;
        $order_col = 'category_id';
        $order_asc = 'desc';
        $keyword = $request->get('keyword');

        $query = Category::query();
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        $query->orderBy($order_col, $order_asc);

        $categories = $query->paginate($per_page);

        return view('admin.pages.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.pages.categories.form', [
            'category' => new Category,
            'name' => 'Tambah Kategori',
        ]);
    }

    public function store(Request $request)
    {
        $category = new Category;
        $this->save($category, $request);

        return redirect()
            ->route('admin::categories.index')
            ->with('info', "Kategori '{$category->name}' berhasil ditambahkan.");
    }

    public function show(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.pages.categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.pages.categories.form', [
            'category' => $category,
            'title' => "Edit Kategori",
            'name' => $category->name,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->save($category, $request);

        return redirect()
            ->route('admin::categories.index')
            ->with('info', "Kategori '{$category->name}' berhasil di update.");
    }

    public function delete(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()
            ->with('info', "Kategori '{$category->name}' telah dihapus.");
    }

    public function save(Category $category, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category->name = $request->get('name');
        $category->slug = str_slug($category->name);
        $category->save();
    }
}
