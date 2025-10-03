<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Create product form
    public function create()
    {
        return view('products.create'); // 👈 points to resources/views/products/create.blade.php
    }

    // Edit form
    public function edit($id)
    {
        $editProduct = Product::find($id);
        return view('products.edit', compact('editProduct'));
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

        // Order newest first, paginate 6 per page
        $products = $query->latest()->paginate(6);

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
            'price' => 'required|numeric|min:0|max:1000000',
            'stock' => 'required|integer|min:0|max:1000000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10000', // max 10MB
        ], [
            'image.max' => 'The image is too large. Maximum size allowed is 10 MB.',
            'image.mimes' => 'Only JPG, JPEG, or PNG files are allowed.',
            'name.max' => 'The name is too long. Max 255 characters.',
            'price.min' => 'Price must be positive number.',
            'price.max' => 'Price must not exceed 1,000,000.',
            'stock.min' => 'Quantity must be positive number.',
            'stock.max' => 'Quantity must not exceed 1,000,000.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.create')->with('success', 'Product added successfully');
    }

    public function update(Request $request, $id){
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:1000000',
            'stock' => 'required|integer|min:0|max:1000000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10000', // max 10MB
        ], [
            'image.max' => 'The image is too large. Maximum size allowed is 10 MB.',
            'image.mimes' => 'Only JPG, JPEG, or PNG files are allowed.',
            'name.max' => 'The name is too long. Max 255 characters.',
            'price.min' => 'Price must be positive number.',
            'price.max' => 'Price must not exceed 1,000,000.',
            'stock.min' => 'Quantity must be positive number.',
            'stock.max' => 'Quantity must not exceed 1,000,000.',
        ]);

        $item = Product::find($id);

        // Handle image upload if a new file was provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $item->update($validated);

        return redirect()->route('products.edit', $id)->with('success', 'Product edited successfully!');
    }
}
