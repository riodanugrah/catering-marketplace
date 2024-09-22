<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

Config::$serverKey = env('MIDTRANS_SERVER_KEY');
Config::$isProduction = false; // Ganti true jika ingin production

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $request->total_price,
            ],
            'customer_details' => [
                'first_name' => $request->user()->name,
                'email' => $request->user()->email,
            ]
        ];

        $paymentUrl = Snap::createTransaction($params)->redirect_url;
        return redirect($paymentUrl);
    }
}
