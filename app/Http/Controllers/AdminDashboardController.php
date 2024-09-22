<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\MerchantProfile;

class AdminDashboardController extends Controller
{
    // Fungsi untuk menampilkan dashboard admin
    public function index()
    {
        $merchants = MerchantProfile::all();
        $customers = User::where('role', 'customer')->get();
        $orders = Order::all();
        return view('admin.dashboard', compact('merchants', 'customers', 'orders'));
    }

    // CRUD untuk Merchant
    public function createMerchant()
    {
        return view('admin.merchants.create');
    }

    public function storeMerchant(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'description' => 'required',
            'user_id' => 'required|exists:users,id',  // user yang terdaftar
        ]);

        MerchantProfile::create([
            'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'contact' => $request->contact,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Merchant created successfully');
    }

    public function editMerchant(MerchantProfile $merchant)
    {
        return view('admin.merchants.edit', compact('merchant'));
    }

    public function updateMerchant(
        Request $request,
        MerchantProfile $merchant
    ) {
        $request->validate([
            'company_name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'description' => 'required',
        ]);

        $merchant->update($request->only(['company_name', 'address', 'contact', 'description']));

        return redirect()->route('admin.dashboard')->with('success', 'Merchant updated successfully');
    }

    public function destroyMerchant(MerchantProfile $merchant)
    {
        $merchant->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Merchant deleted successfully');
    }

    // CRUD untuk Customer
    public function editCustomer(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function updateCustomer(
        Request $request,
        User $customer
    ) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $customer->id,
        ]);

        $customer->update($request->only(['name', 'email']));

        return redirect()->route('admin.dashboard')->with('success', 'Customer updated successfully');
    }

    public function destroyCustomer(User $customer)
    {
        $customer->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Customer deleted successfully');
    }

    // CRUD untuk Order
    public function editOrder(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'delivery_date' => 'required|date',
        ]);

        $order->update($request->only(['quantity', 'delivery_date']));

        return redirect()->route('admin.dashboard')->with('success', 'Order updated successfully');
    }

    public function destroyOrder(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Order deleted successfully');
    }
}
