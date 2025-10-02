@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Add New Product</h2>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block font-medium">Product Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <div>
            <label class="block font-medium">Price</label>
            <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block font-medium">Stock</label>
            <input type="number" name="stock" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <div class="flex gap-3 items-baseline">
                <label class="block font-medium">Product Image</label>
                <span class="text-xs">Max file size: 10MB</span>
            </div>
            <div class="flex items-center space-x-3 mt-3">
                <label class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 hover:cursor-pointer mb-0">
                    <span>Select Image</span>
                    <input type="file" name="image" class="hidden" onchange="document.getElementById('file-name').textContent = this.files[0] ? this.files[0].name : 'No file selected';">
                </label>
                <span id="file-name" class="text-gray-700">No file selected</span>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 hover:cursor-pointer">Add Product</button>
            <a href="{{ route('home') }}"
            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 hover:cursor-pointer hover:cursor-pointer flex text-center">
                Go Back to Home
            </a>
        </div>
    </form>

    @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 mt-3">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 mt-3">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection