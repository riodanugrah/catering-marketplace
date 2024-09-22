<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Notifications\OrderPlaced;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'quantity' => 'required|integer',
            'delivery_date' => 'required|date',
        ]);

        // Logika untuk membuat order
        $order = Order::create([
            'menu_id' => $request->menu_id,
            'user_id' => auth()->id(),
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date,
        ]);

        // Kirim notifikasi ke merchant
        $merchant = $order->menu->merchantProfile->user;
        $merchant->notify(new OrderPlaced($order));

        return redirect()->route('orders.success');
    }

    public function index()
    {
        $orders = auth()->user()->orders;
        return view('customer.orders.index', compact('orders'));
    }
}
