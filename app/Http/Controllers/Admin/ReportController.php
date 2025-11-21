<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        // User Statistics
        $userStats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'farmer' => User::where('role', 'farmer')->count(),
            'partner' => User::where('role', 'partner')->count(),
        ];
        
        // Product Statistics
        $productStats = [
            'total' => Product::count(),
            'approved' => Product::where('status', 'approved')->count(),
            'pending' => Product::where('status', 'pending')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];
        
        // Order Statistics
        $orderStats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        // Revenue Statistics
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalItemsSold = OrderItem::whereHas('order', function($q) {
            $q->where('status', 'completed');
        })->sum('quantity');
        
        // Monthly revenue (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $revenue = Order::where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total');
            
            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue,
            ];
        }
        $monthlyRevenue = collect($monthlyRevenue);
        
        // User growth (last 6 months)
        $userGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $count = User::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            
            $userGrowth[] = [
                'month' => $month->format('M Y'),
                'count' => $count,
            ];
        }
        $userGrowth = collect($userGrowth);
        
        // Product growth (last 6 months)
        $productGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $count = Product::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            
            $productGrowth[] = [
                'month' => $month->format('M Y'),
                'count' => $count,
            ];
        }
        $productGrowth = collect($productGrowth);
        
        // Order growth (last 6 months)
        $orderGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $count = Order::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            
            $orderGrowth[] = [
                'month' => $month->format('M Y'),
                'count' => $count,
            ];
        }
        $orderGrowth = collect($orderGrowth);
        
        return view('admin.reports', compact(
            'userStats', 
            'productStats', 
            'orderStats', 
            'totalRevenue', 
            'totalItemsSold',
            'monthlyRevenue',
            'userGrowth',
            'productGrowth',
            'orderGrowth'
        ));
    }

    public function exportPdf()
    {
        // Get all statistics
        $userStats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'farmer' => User::where('role', 'farmer')->count(),
            'partner' => User::where('role', 'partner')->count(),
        ];
        
        $productStats = [
            'total' => Product::count(),
            'approved' => Product::where('status', 'approved')->count(),
            'pending' => Product::where('status', 'pending')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];
        
        $orderStats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalItemsSold = OrderItem::whereHas('order', function($q) {
            $q->where('status', 'completed');
        })->sum('quantity');

        // Get recent orders
        $recentOrders = Order::with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get top products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) {
                $q->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->with('product')
            ->get();

        $data = [
            'userStats' => $userStats,
            'productStats' => $productStats,
            'orderStats' => $orderStats,
            'totalRevenue' => $totalRevenue,
            'totalItemsSold' => $totalItemsSold,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'generatedAt' => Carbon::now()->format('d F Y H:i:s'),
        ];

        $pdf = Pdf::loadView('admin.reports-pdf', $data);
        return $pdf->download('laporan-weplant-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        // Get all statistics
        $userStats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'farmer' => User::where('role', 'farmer')->count(),
            'partner' => User::where('role', 'partner')->count(),
        ];
        
        $productStats = [
            'total' => Product::count(),
            'approved' => Product::where('status', 'approved')->count(),
            'pending' => Product::where('status', 'pending')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];
        
        $orderStats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalItemsSold = OrderItem::whereHas('order', function($q) {
            $q->where('status', 'completed');
        })->sum('quantity');

        // Get all orders with details
        $orders = Order::with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->get();

        // Create Excel data
        $data = [
            ['LAPORAN WEPLAN(T)', '', '', '', ''],
            ['Dibuat pada', Carbon::now()->format('d F Y H:i:s'), '', '', ''],
            ['', '', '', '', ''],
            ['STATISTIK PENGGUNA', '', '', '', ''],
            ['Total Pengguna', $userStats['total'], '', '', ''],
            ['Admin', $userStats['admin'], '', '', ''],
            ['Petani', $userStats['farmer'], '', '', ''],
            ['Mitra', $userStats['partner'], '', '', ''],
            ['', '', '', '', ''],
            ['STATISTIK PRODUK', '', '', '', ''],
            ['Total Produk', $productStats['total'], '', '', ''],
            ['Disetujui', $productStats['approved'], '', '', ''],
            ['Menunggu', $productStats['pending'], '', '', ''],
            ['Ditolak', $productStats['rejected'], '', '', ''],
            ['', '', '', '', ''],
            ['STATISTIK PESANAN', '', '', '', ''],
            ['Total Pesanan', $orderStats['total'], '', '', ''],
            ['Menunggu', $orderStats['pending'], '', '', ''],
            ['Diproses', $orderStats['processing'], '', '', ''],
            ['Dikirim', $orderStats['shipped'], '', '', ''],
            ['Selesai', $orderStats['completed'], '', '', ''],
            ['Dibatalkan', $orderStats['cancelled'], '', '', ''],
            ['', '', '', '', ''],
            ['PENDAPATAN', '', '', '', ''],
            ['Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'), '', '', ''],
            ['Total Item Terjual', $totalItemsSold, '', '', ''],
            ['', '', '', '', ''],
            ['DETAIL PESANAN', '', '', '', ''],
            ['No. Pesanan', 'Tanggal', 'Pelanggan', 'Total', 'Status'],
        ];

        foreach ($orders as $index => $order) {
            $data[] = [
                $order->order_number,
                $order->created_at->format('d/m/Y H:i'),
                $order->name,
                'Rp ' . number_format($order->total, 0, ',', '.'),
                ucfirst($order->status),
            ];
        }

        $filename = 'laporan-weplant-' . Carbon::now()->format('Y-m-d') . '.csv';
        
        // Create CSV content
        $csvContent = "\xEF\xBB\xBF"; // UTF-8 BOM for Excel
        foreach ($data as $row) {
            $csvContent .= implode(',', array_map(function($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row)) . "\n";
        }
        
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
