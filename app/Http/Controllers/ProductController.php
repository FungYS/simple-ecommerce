<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Show form
    public function create()
    {
        return view('products.create'); // 👈 points to resources/views/products/create.blade.php
    }

    public function index(Request $request)
    {
        $query = Product::query();

        // If search exists, filter products
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Order newest first, paginate 12 per page
        $products = $query->latest()->paginate(12);

        // Keep search keyword in pagination links
        $products->appends($request->only('search'));

        return view('home', compact('products'));
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10000', // max 10MB
        ], [
            'image.max' => 'The image is too large. Maximum size allowed is 10 MB.',
            'image.mimes' => 'Only JPG, JPEG, or PNG files are allowed.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.create')->with('success', 'Product added successfully');
    }
}
