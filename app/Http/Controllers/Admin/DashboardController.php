<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['productsCount'] = Product::count();
        $data['membersCount'] = User::where('type', User::TYPE_MEMBER)->count();
        $data['salesCount'] = Order::where('status', Order::STATUS_FINISH)->count();

        $onProgressStatuses = [
            Order::STATUS_PENDING,
            Order::STATUS_PROCESSING,
            Order::STATUS_SHIPPING,
        ];

        $data['onProgressOrderCount'] = Order::whereIn('status', $onProgressStatuses)->count();
        $data['onProgressOrders'] = Order::whereIn('status', $onProgressStatuses)->get();

        return view('admin.pages.dashboard.index', $data);
    }
}
