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
                <th class="p-2 border">Action</th>
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
                <!-- Image + Name -->
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

                <!-- Price -->
                <td class="p-2 border md:table-cell flex justify-between md:justify-center items-center">
                    <span class="font-semibold md:hidden">Price:</span>
                    RM {{ number_format($item['price'], 2) }}
                </td>

                <!-- Quantity -->
                <td class="p-2 border md:table-cell flex justify-between md:justify-center items-center">
                    <span class="font-semibold md:hidden">Quantity:</span>

                    <form action="{{ route('cart.updateQty', $id) }}" method="POST" class="flex items-center justify-center space-x-2">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                            class="w-16 border rounded px-1 py-1.5 text-center">
                        <button type="submit"
                                class="bg-blue-500 text-white px-2 py-2 rounded hover:bg-blue-600 hover:cursor-pointer">
                            Update
                        </button>
                    </form>
                </td>

                <!-- Subtotal -->
                <td class="p-2 border md:table-cell flex justify-between md:justify-center items-center">
                    <span class="font-semibold md:hidden">Subtotal:</span>
                    RM {{ number_format($subtotal, 2) }}
                </td>

                <!-- Actions -->
                <td class="p-2 border md:table-cell text-center">
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-red-500 text-white px-2 py-2 rounded hover:bg-red-600 hover:cursor-pointer">
                            Remove
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded my-4">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="mt-4 text-right">
        <h3 class="text-xl font-bold">Total: RM {{ number_format($total, 2) }}</h3>

        <div class="flex gap-3 justify-end">
            <a href="{{ route('home') }}"
                class="inline-block w-fit bg-blue-600 text-white mt-2 px-4 py-2 rounded hover:bg-blue-700 hover:cursor-pointer text-center">
                Add More Items
            </a>
            <a href="{{ route('cart.clear') }}"
                class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 hover:cursor-pointer">
                Clear Cart
            </a>
            <form action="{{ route('cart.placeOrder') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="mt-2 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 hover:cursor-pointer">
                    Place Order
                </button>
            </form>
        </div>
    </div>
@endif
@endsection
