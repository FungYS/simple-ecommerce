<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')->get();
        return view('orders.index', compact('orders'));
    }

    public function placeOrder()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Cart is empty!');
        }

        // Calculate total
        $total = 0;

        // Check stock for each product
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product) {
                return redirect()->route('cart.index')->withErrors(['order' => "Product not found: {$item['name']}"]);
            }

            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')->withErrors(['order' => "Not enough stock for {$product->name}. Available: {$product->stock}"]);
            }

            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'customer_name' => 'Placeholder Customer Name', // to change to id if add login
            'status' => 'pending',
            'total' => $total,
        ]);

        // Save items
        foreach ($cart as $id => $item) {
            $order->items()->create([
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Deduct stock from product
            $product = Product::find($id);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('home')->with('order_success', 'Order placed successfully!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }


}
