@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="mb-6">
    @if(session('order_success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 mt-3">
        {{ session('order_success') }}
    </div>
    @endif

    <h2 class="text-2xl font-bold">Actions</h2>
    <div class="inline-flex flex flex-wrap gap-3">
        <div class="inline-block text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <a href="{{ route('products.create') }}">
                Add Product
            </a>
        </div>

        <div class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 w-fit">
            <a href="{{ route('orders.index') }}">
                View Orders
            </a>
        </div>
    </div>

</div>

<h2 class="text-2xl font-bold mb-4">Product Catalogue Test</h2>
<form action="{{ route('home') }}" method="GET" class="mb-6 flex gap-2">
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Search products name and description..."
           class="border px-3 py-2 rounded w-full md:w-1/3">
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 hover:cursor-pointer">
        Search
    </button>

    @if(request('search'))
        <a href="{{ route('home') }}"
           class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
            Clear
        </a>
    @endif
</form>

@if($products->isEmpty())
    <p class="text-gray-600">No products available.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded shadow p-4 flex flex-col">
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-60 object-cover rounded mb-3">
                @else
                    <img src="https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png"
                        alt="No image available"
                        class="w-full h-60 object-cover rounded mb-3">
                @endif
                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm flex-1">{{ $product->description }}</p>
                <p class="mt-2 font-semibold">RM {{ number_format($product->price, 2) }}</p>
                <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>

                @if($product->stock != 0)
                <form class="ajax-add-to-cart text-center" action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="mt-3 bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 hover:cursor-pointer">
                        Add to Cart
                    </button>
                </form>
                @else
                <button class="text-center w-fit mt-3 mx-auto bg-gray-200 px-3 py-2 rounded cursor-not-allowed" disabled>Out of stock!</button>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endif
@endsection
