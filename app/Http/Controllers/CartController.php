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
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // how many already in cart
        $currentQtyInCart = isset($cart[$id]) ? (int)$cart[$id]['quantity'] : 0;
        $addQty = (int) $request->input('quantity', 1);

        // prevent negative/zero
        if ($addQty <= 0) {
            $addQty = 1;
        }

        // check stock
        if ($currentQtyInCart + $addQty > $product->stock) {
            $message = 'Cannot add product to cart — not enough stock available.';

            $count = array_sum(array_column($cart, 'quantity'));

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $message,
                    'cartCount' => $count
                ], 422);
            }
            return redirect()->back()->withErrors(['stock' => $message])->withInput();
        }

        // OK to add
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $currentQtyInCart + $addQty;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $addQty,
                'image_path' => $product->image_path,
            ];
        }

        session()->put('cart', $cart);

        $count = array_sum(array_column($cart, 'quantity'));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Product added to cart',
                'cartCount' => $count,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // Update quantity of a cart item
    public function updateQty(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Item not found in cart']);
        }

        $product = Product::findOrFail($id);
        $newQty = (int) $request->input('quantity', 1);

        // validate stock
        if ($newQty > $product->stock) {
            return redirect()->route('cart.index')->withErrors([
                'cart' => "Not enough stock for {$product->name}. Available: {$product->stock}"
            ]);
        }

        if ($newQty <= 0) {
            unset($cart[$id]); // remove if quantity 0 or less
        } else {
            $cart[$id]['quantity'] = $newQty;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    // Remove an item completely
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    // Clear the cart
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}
