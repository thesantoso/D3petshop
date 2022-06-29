<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemberAddress;

class MemberAddressController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $addresses = $user->member_addresses()
            ->with([
                'province',
                'regency',
                'district',
                'subdistrict',
            ])
            ->orderBy('is_default', 'desc')
            ->get();

        return view('front.pages.account.addresses', [
            'addresses' => $addresses,
        ]);
    }

    public function all(Request $request)
    {
        $user = auth()->user();
        $addresses = $user
            ->member_addresses()
            ->with([
                'province',
                'regency',
                'district',
                'subdistrict',
            ])
            ->orderBy('is_default', 'desc')
            ->get();

        return response()->json([
            'data' => $addresses
        ]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'subdistrict_id' => 'required|exists:subdistricts,id',
            'address' => 'required',
            'is_default' => 'in:1,0'
        ]);

        $user = auth()->user();
        $address_count = $user->member_addresses()->count();

        $address = new MemberAddress;
        $address->user_id = $user->getKey();
        $address->name = $request->get('name');
        $address->phone = $request->get('phone');
        $address->province_id = $request->get('province_id');
        $address->regency_id = $request->get('regency_id');
        $address->district_id = $request->get('district_id');
        $address->subdistrict_id = $request->get('subdistrict_id');
        $address->address = $request->get('address');
        $address->is_default = $request->get('is_default') ?: 0;

        if ($address_count == 0) {
            $address->is_default = 1;
        }

        $address->save();

        return response()->json([
            'data' => $address->toArray(),
        ]);
    }

    public function find(Request $request, $member_address_id)
    {
        $user = auth()->user();
        $address = $user->member_addresses()
            ->with([
                'province',
                'regency',
                'district',
                'subdistrict',
            ])
            ->where('member_address_id', $member_address_id)
            ->first();

        if (!$address) {
            return abort(404, "Data alamat tidak ditemukan");
        }

        return response()->json([
            'data' => $user
                ->member_addresses()
                ->with([
                    'province',
                    'regency',
                    'district',
                    'subdistrict',
                ])
                ->where('member_address_id', $address->getKey())
                ->first(),
        ]);
    }

    public function update(Request $request, $member_address_id)
    {
        $user = auth()->user();
        $address = $user->member_addresses()->where('member_address_id', $member_address_id)->first();
        if (!$address) {
            return abort(404, "Data alamat tidak ditemukan");
        }

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'subdistrict_id' => 'required|exists:subdistricts,id',
            'address' => 'required',
            'is_default' => 'in:1,0'
        ]);

        $address->user_id = $user->getKey();
        $address->name = $request->get('name');
        $address->phone = $request->get('phone');
        $address->province_id = $request->get('province_id');
        $address->regency_id = $request->get('regency_id');
        $address->district_id = $request->get('district_id');
        $address->subdistrict_id = $request->get('subdistrict_id');
        $address->address = $request->get('address');
        $address->is_default = $request->get('is_default') ?: $address->is_default ?: 0;
        $address->save();

        if ($address->is_default == 1) {
            $user->member_addresses()->whereNotIn('member_address_id', [$address->member_address_id])->update([
                'is_default' => 0
            ]);
        }

        return response()->json([
            'data' => $user
                ->member_addresses()
                ->with([
                    'province',
                    'regency',
                    'district',
                    'subdistrict',
                ])
                ->where('member_address_id', $address->getKey())
                ->first()
        ]);
    }

    public function setDefault(Request $request, $member_address_id)
    {
        $user = auth()->user();
        $address = $user->member_addresses()->where('member_address_id', $member_address_id)->first();
        if (!$address) {
            return abort(404, "Data alamat tidak ditemukan");
        }

        $address->is_default = 1;
        $address->save();

        $user->member_addresses()->whereNotIn('member_address_id', [$address->member_address_id])->update([
            'is_default' => 0
        ]);

        return back();
    }

    public function delete(Request $request, $member_address_id)
    {
        $user = auth()->user();
        $address = $user->member_addresses()->where('member_address_id', $member_address_id)->first();
        if (!$address) {
            return abort(404, "Data alamat tidak ditemukan");
        }

        $address->delete();

        if ($address->is_default == 1 && $other_address = $user->member_addresses()->first()) {
            $other_address->is_default = 1;
            $other_address->save();
        }

        return back();
    }
}
