<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $per_page = 10;
        $order_col = 'order_id';
        $order_asc = 'desc';

        $query = Order::has('member')->with([
            'member',
            'province',
            'regency',
            'district',
            'subdistrict',
        ]);

        if ($status) {
            $query->where('status', $status);
        }

        $query->orderBy($order_col, $order_asc);

        $orders = $query->paginate($per_page);

        return view('admin.pages.orders.index', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        return view('admin.pages.orders.show', [
            'order' => $order
        ]);
    }

    public function setStatus(Request $request, $id)
    {
        $status = $request->get('status');
        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();

        return back()->with('info', "Pesanan '{$order->code}' diubah statusnya menjadi '{$status}'");
    }

    public function delete(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->details()->delete();
        $order->delete();

        return back()->with('info', "Pesanan '{$order->code}' telah dihapus.");
    }
}
