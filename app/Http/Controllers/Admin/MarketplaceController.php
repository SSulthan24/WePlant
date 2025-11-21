<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    public function index()
    {
        // Stats
        $stats = [
            'total_products' => Product::where('status', 'approved')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
            'active_partners' => User::where('role', 'partner')
                ->whereHas('products', function($q) {
                    $q->where('status', 'approved');
                })->count(),
        ];
        
        // Recent orders
        $recentOrders = Order::with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Top selling products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        // Orders by status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        return view('admin.marketplace', compact('stats', 'recentOrders', 'topProducts', 'ordersByStatus'));
    }
}
