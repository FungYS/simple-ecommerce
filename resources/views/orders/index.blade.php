@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<h2 class="text-2xl font-bold mb-4">Orders</h2>

@foreach($orders as $order)

<div class="border p-4 rounded mb-4">
    <p class="inline-flex">
        <strong>Order #{{ $order->id }}</strong> -
        Status:
        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <select name="status" onchange="this.form.submit()" class="border rounded p-1">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </p>

    <p>Customer: {{ ucfirst($order->customer_name) }}</p>
    <p>Total: RM {{ number_format($order->total, 2) }}</p>
    <div class="mt-2">
        <p><strong>Products Purchased</strong></p>
        <hr>
        <ul>
            @foreach($order->items as $item)
                <li>{{ $item->product->name }} (x{{ $item->quantity }}) - RM {{ number_format($item->price, 2) }}</li>
            @endforeach
        </ul>
    </div>
</div>

@endforeach

<div class="flex gap-3">
    <a href="{{ route('home') }}"
    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 hover:cursor-pointer hover:cursor-pointer flex text-center">
        Go Back to Home
    </a>
</div>
@endsection
