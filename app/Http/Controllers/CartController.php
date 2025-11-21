<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[$id] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ];
                $total += $cartItems[$id]['subtotal'];
            }
        }
        
        return view('pages.cart', compact('cartItems', 'total'));
    }
    
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->stock < 1) {
            return back()->with('error', 'Produk tidak tersedia');
        }
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] >= $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'quantity' => 1,
            ];
        }
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $quantity = (int) $request->quantity;
            
            if ($quantity <= 0) {
                unset($cart[$id]);
            } elseif ($quantity > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi');
            } else {
                $cart[$id]['quantity'] = $quantity;
            }
            
            session()->put('cart', $cart);
        }
        
        return back()->with('success', 'Keranjang diperbarui');
    }
    
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
