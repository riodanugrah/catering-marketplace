<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerchantProfile;

class MerchantProfileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'description' => 'required',
        ]);

        MerchantProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'company_name' => $request->company_name,
                'address' => $request->address,
                'contact' => $request->contact,
                'description' => $request->description,
            ]
        );

        return redirect()->route('merchant.profile');
    }
}
