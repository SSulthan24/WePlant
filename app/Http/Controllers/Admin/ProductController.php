<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Product::with('partner');
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());
        
        $stats = [
            'total' => Product::count(),
            'pending' => Product::where('status', 'pending')->count(),
            'approved' => Product::where('status', 'approved')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];
        
        return view('admin.products', compact('products', 'stats', 'status'));
    }
    
    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'approved';
        $product->save();
        
        return back()->with('success', 'Produk berhasil disetujui');
    }
    
    public function reject($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'rejected';
        $product->save();
        
        return back()->with('success', 'Produk ditolak');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        
        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();
        
        $statusText = [
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];
        
        return back()->with('success', 'Status produk berhasil diubah menjadi ' . $statusText[$request->status]);
    }
}
