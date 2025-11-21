<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $partnerId = auth()->id();
        
        // Get order items for this partner's products
        $orderItemsQuery = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->with(['product', 'order']);
        
        // Total sales (from completed orders only)
        $totalSales = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })->sum('subtotal');
        
        // Total orders
        $totalOrders = Order::whereHas('items.product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->where('status', 'completed')->count();
        
        // Best selling product
        $bestSellingProduct = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
        ->with('product')
        ->groupBy('product_id')
        ->orderBy('total_sold', 'desc')
        ->first();
        
        // Average per order
        $avgPerOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        
        // Monthly sales data (last 6 months)
        $monthlySalesData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $sales = OrderItem::whereHas('product', function($q) use ($partnerId) {
                $q->where('partner_id', $partnerId);
            })->whereHas('order', function($q) use ($monthStart, $monthEnd) {
                $q->where('status', 'completed')
                  ->whereBetween('created_at', [$monthStart, $monthEnd]);
            })->sum('subtotal');
            
            $monthlySalesData[] = [
                'month' => $month->format('M Y'),
                'sales' => $sales,
            ];
        }
        $monthlySales = collect($monthlySalesData);
        
        // Top selling products
        $topProducts = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
        ->with('product')
        ->groupBy('product_id')
        ->orderBy('total_sold', 'desc')
        ->limit(5)
        ->get();
        
        // Sales details (recent sales)
        $salesDetails = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->with(['product', 'order'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        
        $stats = [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'best_selling_product' => $bestSellingProduct ? $bestSellingProduct->product->name : '-',
            'avg_per_order' => $avgPerOrder,
        ];
        
        return view('partner.sales-report', compact('stats', 'monthlySales', 'topProducts', 'salesDetails'));
    }

    public function exportPdf()
    {
        $partnerId = auth()->id();
        
        // Get all statistics
        $totalSales = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })->sum('subtotal');
        
        $totalOrders = Order::whereHas('items.product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->where('status', 'completed')->count();
        
        $bestSellingProduct = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
        ->with('product')
        ->groupBy('product_id')
        ->orderBy('total_sold', 'desc')
        ->first();
        
        $avgPerOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        
        // Monthly sales data (last 6 months)
        $monthlySalesData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $sales = OrderItem::whereHas('product', function($q) use ($partnerId) {
                $q->where('partner_id', $partnerId);
            })->whereHas('order', function($q) use ($monthStart, $monthEnd) {
                $q->where('status', 'completed')
                  ->whereBetween('created_at', [$monthStart, $monthEnd]);
            })->sum('subtotal');
            
            $monthlySalesData[] = [
                'month' => $month->format('M Y'),
                'sales' => $sales,
            ];
        }
        
        // Top selling products
        $topProducts = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
        ->with('product')
        ->groupBy('product_id')
        ->orderBy('total_sold', 'desc')
        ->limit(5)
        ->get();
        
        // Sales details (all sales, not paginated)
        $salesDetails = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->with(['product', 'order'])
        ->orderBy('created_at', 'desc')
        ->limit(50)
        ->get();

        $data = [
            'partnerName' => auth()->user()->name,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'bestSellingProduct' => $bestSellingProduct ? $bestSellingProduct->product->name : '-',
            'avgPerOrder' => $avgPerOrder,
            'monthlySalesData' => $monthlySalesData,
            'topProducts' => $topProducts,
            'salesDetails' => $salesDetails,
            'generatedAt' => Carbon::now()->format('d F Y H:i:s'),
        ];

        $pdf = Pdf::loadView('partner.sales-report-pdf', $data);
        return $pdf->download('laporan-penjualan-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        $partnerId = auth()->id();
        
        // Get all statistics
        $totalSales = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })->sum('subtotal');
        
        $totalOrders = Order::whereHas('items.product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->where('status', 'completed')->count();
        
        $bestSellingProduct = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
        ->with('product')
        ->groupBy('product_id')
        ->orderBy('total_sold', 'desc')
        ->first();
        
        $avgPerOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        
        // Get all sales details
        $salesDetails = OrderItem::whereHas('product', function($q) use ($partnerId) {
            $q->where('partner_id', $partnerId);
        })->whereHas('order', function($q) {
            $q->where('status', 'completed');
        })
        ->with(['product', 'order'])
        ->orderBy('created_at', 'desc')
        ->get();

        // Create Excel data
        $data = [
            ['LAPORAN PENJUALAN WEPLAN(T)', '', '', '', '', ''],
            ['Mitra', auth()->user()->name, '', '', '', ''],
            ['Dibuat pada', Carbon::now()->format('d F Y H:i:s'), '', '', '', ''],
            ['', '', '', '', '', ''],
            ['STATISTIK PENJUALAN', '', '', '', '', ''],
            ['Total Penjualan', 'Rp ' . number_format($totalSales, 0, ',', '.'), '', '', '', ''],
            ['Total Pesanan', $totalOrders, '', '', '', ''],
            ['Produk Terlaris', $bestSellingProduct ? $bestSellingProduct->product->name : '-', '', '', '', ''],
            ['Rata-rata per Pesanan', 'Rp ' . number_format($avgPerOrder, 0, ',', '.'), '', '', '', ''],
            ['', '', '', '', '', ''],
            ['DETAIL PENJUALAN', '', '', '', '', ''],
            ['Tanggal', 'No. Pesanan', 'Produk', 'Jumlah', 'Harga Satuan', 'Total'],
        ];

        foreach ($salesDetails as $item) {
            $data[] = [
                $item->created_at->format('d/m/Y H:i'),
                $item->order->order_number,
                $item->product->name ?? 'N/A',
                $item->quantity,
                'Rp ' . number_format($item->price, 0, ',', '.'),
                'Rp ' . number_format($item->subtotal, 0, ',', '.'),
            ];
        }

        $filename = 'laporan-penjualan-' . Carbon::now()->format('Y-m-d') . '.csv';
        
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
