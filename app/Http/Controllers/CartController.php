<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Show cart
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        return view('cart.details', compact('cart'));
    }

    // Add item to cart
    public function add(Request $request, $id)
    {
        $product = Product::find($id);

        $cart = session()->get('cart', []);
        $cartModified = false;

        // Add item to the session cart; if it already exists, increment its quantity
        if ($product) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = (int)$cart[$id]['quantity'] + 1;
            } else {
                $cart[$id] = [
                    "name" => $product->name,
                    "price" => $product->price,
                    "quantity" => 1,
                    "image_path" => $product->image_path,
                ];
            }
            $cartModified = true;
        }

        if ($cartModified) {
            session()->put('cart', $cart);
        }

        $count = array_sum(array_column($cart, 'quantity'));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Product added to cart',
                'cartCount' => $count,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // Clear the cart
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}
