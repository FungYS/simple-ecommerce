@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>

@if(empty($cart))

    <div class="block">
        <p class="text-gray-600 mb-4">Your cart is empty.</p>

        <a href="{{ route('home') }}" 
            class="block w-fit bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 hover:cursor-pointer text-center">
            Add Items
        </a>    

        @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 mt-3">
            {{ session('success') }}
        </div>
        @endif
    </div>
@else
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 hidden md:table-row">
                <th class="p-2 border">Product</th>
                <th class="p-2 border">Price</th>
                <th class="p-2 border">Quantity</th>
                <th class="p-2 border">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
            @php 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            @endphp
            <tr class="flex flex-col md:table-row mb-4 md:mb-0 bg-white md:bg-transparent shadow md:shadow-none rounded md:rounded-none overflow-hidden">
                <td class="p-2 border md:table-cell">
                    <div class="flex items-center space-x-2">
                        @if($item['image_path'])
                            <img src="{{ asset('storage/' . $item['image_path']) }}" class="w-12 h-12 object-cover rounded">
                        @else
                            <img 
                            src="https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png" 
                            class="w-12 h-12 object-cover rounded">
                        @endif
                        <span class="text-ellipsis">{{ $item['name'] }}</span>
                    </div>
                </td>
                <td class="p-2 border md:table-cell flex justify-between md:justify-center items-center">
                <span class="font-semibold md:hidden">Price:</span>
                RM {{ number_format($item['price'], 2) }}
                </td>
                <td class="p-2 border md:table-cell flex justify-between md:justify-center items-center">
                <span class="font-semibold md:hidden">Quantity:</span>
                {{ $item['quantity'] }}
                </td>
                <td class="p-2 border md:table-cell flex justify-between md:justify-center items-center">
                <span class="font-semibold md:hidden">Subtotal:</span>
                RM {{ number_format($subtotal, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 text-right">
        <h3 class="text-xl font-bold">Total: RM {{ number_format($total, 2) }}</h3>

        <div class="flex gap-3 justify-end">
            <a href="{{ route('cart.clear') }}" 
                class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Clear Cart
            </a>
            <form action="{{ route('cart.placeOrder') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Place Order
                </button>
            </form>
        </div>
    </div>
@endif
@endsection
