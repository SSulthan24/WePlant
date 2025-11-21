<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong');
        }
        
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
        
        return view('pages.checkout', compact('cartItems', 'total'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:transfer,bank,cod',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong');
        }
        
        // Calculate total
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $total += $product->price * $item['quantity'];
            }
        }
        
        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'total' => $total,
        ]);
        
        // Create order items
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);
                
                // Update product stock
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }
        
        session()->forget('cart');
        
        return redirect()->route('shop')->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
    }
}
