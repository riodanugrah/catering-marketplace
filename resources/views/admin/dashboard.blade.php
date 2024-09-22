@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Admin Dashboard</h1>

    {{-- Data Merchants --}}
    <h2 class="text-2xl font-semibold mt-6">Merchants</h2>
    <a href="{{ route('admin.merchants.create') }}" class="btn btn-primary">Add Merchant</a>
    <ul class="list-disc ml-5">
        @foreach ($merchants as $merchant)
            <li>
                {{ $merchant->company_name }} - {{ $merchant->address }}
                <a href="{{ route('admin.merchants.edit', $merchant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.merchants.destroy', $merchant->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    {{-- Data Customers --}}
    <h2 class="text-2xl font-semibold mt-6">Customers</h2>
    <ul class="list-disc ml-5">
        @foreach ($customers as $customer)
            <li>
                {{ $customer->name }} - {{ $customer->email }}
                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    {{-- Data Orders --}}
    <h2 class="text-2xl font-semibold mt-6">Orders</h2>
    <ul class="list-disc ml-5">
        @foreach ($orders as $order)
            <li>
                Order #{{ $order->id }} - Menu: {{ $order->menu->name }} ({{ $order->quantity }} pcs)
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
