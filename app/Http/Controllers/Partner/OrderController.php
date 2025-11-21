<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        // Get orders that contain products from this partner
        $query = Order::whereHas('items.product', function($q) {
            $q->where('partner_id', auth()->id());
        })->with(['items.product', 'user']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());
        
        // Calculate stats
        $allOrders = Order::whereHas('items.product', function($q) {
            $q->where('partner_id', auth()->id());
        });
        
        $stats = [
            'total' => (clone $allOrders)->count(),
            'pending' => (clone $allOrders)->where('status', 'pending')->count(),
            'processing' => (clone $allOrders)->where('status', 'processing')->count(),
            'shipped' => (clone $allOrders)->where('status', 'shipped')->count(),
            'completed' => (clone $allOrders)->where('status', 'completed')->count(),
        ];
        
        return view('partner.orders', compact('orders', 'stats', 'status'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);
        
        $order = Order::whereHas('items.product', function($q) {
            $q->where('partner_id', auth()->id());
        })->findOrFail($id);
        
        $order->status = $request->status;
        $order->save();
        
        $statusText = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        
        return back()->with('success', 'Status pesanan berhasil diubah menjadi ' . $statusText[$request->status]);
    }
    
    public function show($id)
    {
        $order = Order::whereHas('items.product', function($q) {
            $q->where('partner_id', auth()->id());
        })->with(['items.product', 'user'])->findOrFail($id);
        
        return view('partner.order-detail', compact('order'));
    }
}
