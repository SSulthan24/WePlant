<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'approved')->where('stock', '>', 0);
        
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->latest()->paginate(12);
        $categories = Product::where('status', 'approved')->distinct()->pluck('category');
        
        return view('pages.shop', compact('products', 'categories'));
    }
}
