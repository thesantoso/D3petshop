<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShippingCost;

class ShippingCostController extends Controller
{
    public function cost(Request $request, $regency_id)
    {
        $cost = ShippingCost::where('regency_id', $regency_id)->first();
        if (!$cost) {
            return abort(404, "Data tidak tersedia.");
        }

        return response()->json([
            'cost' => (int) $cost->cost
        ]);
    }
}
