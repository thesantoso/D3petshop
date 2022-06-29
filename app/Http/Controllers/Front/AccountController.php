<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $products = OrderDetail::query()
            ->with('product')
            ->has('product')
            ->join('orders', 'orders.order_id', '=', 'order_details.order_id')
            ->where('orders.member_user_id', $user->user_id)
            ->where('orders.status', 'finish')
            ->orderBy('orders.order_id', 'desc')
            ->groupBy('order_details.product_id')
            ->paginate(10);

        return view('front.pages.account.index', [
            'user' => $user,
            'products' => $products,
        ]);
    }

    public function orders(Request $request)
    {
        $user = auth()->user();
        $orders = $user->orders()
            ->with([
                'province',
                'regency',
                'district',
                'subdistrict',
            ])
            ->orderBy('order_id', 'desc')
            ->paginate(10);

        return view('front.pages.account.orders', [
            'orders' => $orders,
        ]);
    }

    public function orderDetail(Request $request, $order_id)
    {
        $user = auth()->user();
        $order = $user->orders()->where('order_id', $order_id)->firstOrFail();

        return view('front.pages.account.order-detail', [
            'order' => $order,
        ]);
    }

    public function changePassword(Request $request)
    {
        return view('front.pages.account.change-password');
    }

    public function submitChangePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $current_password = $request->get('current_password');
        $new_password = $request->get('new_password');

        $user = auth()->user();
        if (!Hash::check($current_password, $user->password)) {
            return back()->with('danger', "Password saat ini tidak cocok.");
        }

        $user->password = bcrypt($new_password);
        $user->save();

        return back()->with('info', "Password anda berhasil diubah.");
    }
}
