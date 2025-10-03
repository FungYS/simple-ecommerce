@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">About the assessment</h1>

    <p class="mb-4">
        This project is made using laravel and tailwindcss with a component using VueJS.
    </p>

    <h3 class="text-xl font-semibold mt-4">Completed Requirements</h3>
    <h2 class="text-lg font-semibold mb-2">Compulsory</h2>
    <ul class="list-none space-y-2 mb-4">
        <li><span class="font-medium">1.</span> Used Laravel to complete assessment.</li>
        <li><span class="font-medium">2.</span> Built catalogue page (home page) that allows people to add product to a cart.</li>
        <li><span class="font-medium">3.</span> Implemented cart page that list added products and a button place an order.</li>
        <li><span class="font-medium">4.</span> Implemented a simple order list that shows the order number, products in the order and a way to change the status of an order.</li>
    </ul>

    <h2 class="text-lg font-semibold mt-4 mb-2">Optional</h2>
    <ul class="list-none space-y-2 mb-4">
        <li><span class="font-medium">1.</span> Dynamic cart icon that shows the number of products total in the user's cart.</li>
        <li><span class="font-medium">2.</span> Used VueJS for the dynamic cart icon.</li>
        <li><span class="font-medium">3.</span> Ability to search products in the product list..</li>
        <li><span class="font-medium">4.</span> In the cart page, able to update the product (change the quantity added) and delete a product from the cart.</li>
    </ul>

    <p class="text-md font-bold text-gray-600 mb-4">
        All compulsory requirements are completed with most optional requirements added.
    </p>

    <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Back to Home
    </a>
</div>
@endsection
