<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Subdistrict;

class RegionController extends Controller
{
    public function provinces(Request $request)
    {
        return response()->json([
            'data' => Province::orderBy('name')->get(),
        ]);
    }

    public function regencies(Request $request)
    {
        $province_id = $request->get('province_id');

        return response()->json([
            'data' => Regency::where('province_id', $province_id)->get(),
        ]);
    }

    public function districts(Request $request)
    {
        $regency_id = $request->get('regency_id');

        return response()->json([
            'data' => District::where('regency_id', $regency_id)->get(),
        ]);
    }

    public function subdistricts(Request $request)
    {
        $district_id = $request->get('district_id');

        return response()->json([
            'data' => Subdistrict::where('district_id', $district_id)->get(),
        ]);
    }

}
