<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('partner_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $stats = [
            'total' => Product::where('partner_id', auth()->id())->count(),
            'approved' => Product::where('partner_id', auth()->id())->where('status', 'approved')->count(),
            'pending' => Product::where('partner_id', auth()->id())->where('status', 'pending')->count(),
            'rejected' => Product::where('partner_id', auth()->id())->where('status', 'rejected')->count(),
        ];
        
        return view('partner.products', compact('products', 'stats'));
    }
    
    public function create()
    {
        return view('partner.product-create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $imageUrl = 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=500';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }
        
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'image' => $imageUrl,
            'partner_id' => auth()->id(),
            'status' => 'pending', // Menunggu approval admin
        ]);
        
        return redirect()->route('partner.products')->with('success', 'Produk berhasil ditambahkan dan menunggu persetujuan admin');
    }
    
    public function edit($id)
    {
        $product = Product::where('partner_id', auth()->id())->findOrFail($id);
        return view('partner.product-edit', compact('product'));
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::where('partner_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;
        
        // Jika status approved, ubah ke pending setelah edit
        if ($product->status === 'approved') {
            $product->status = 'pending';
        }
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = asset('storage/' . $imagePath);
        }
        
        $product->save();
        
        return redirect()->route('partner.products')->with('success', 'Produk berhasil diperbarui dan menunggu persetujuan admin');
    }
    
    public function destroy($id)
    {
        $product = Product::where('partner_id', auth()->id())->findOrFail($id);
        $product->delete();
        
        return back()->with('success', 'Produk berhasil dihapus');
    }
}
