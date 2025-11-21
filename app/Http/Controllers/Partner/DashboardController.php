<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::where('partner_id', auth()->id())->count(),
            'approved_products' => Product::where('partner_id', auth()->id())->where('status', 'approved')->count(),
            'pending_products' => Product::where('partner_id', auth()->id())->where('status', 'pending')->count(),
        ];
        
        return view('partner.dashboard', compact('stats'));
    }
}
