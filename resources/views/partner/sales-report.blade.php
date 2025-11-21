@extends('layouts.dashboard')

@section('title', 'Laporan Penjualan | WePlan(t)')
@section('page-title', 'Laporan Penjualan')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Laporan Penjualan</h2>
                    <p class="text-green-50">Analisis penjualan produk Anda</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="window.location.href='{{ route('partner.sales-report.export-pdf') }}'" class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold whitespace-nowrap">
                        Export PDF
                    </button>
                    <button onclick="window.location.href='{{ route('partner.sales-report.export-excel') }}'" class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold whitespace-nowrap">
                        Export Excel
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in">
                <p class="text-sm text-green-600 mb-1">Total Penjualan</p>
                <p class="text-3xl font-bold text-green-900">Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}</p>
                <p class="text-xs text-green-600 mt-1">Dari pesanan selesai</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.1s">
                <p class="text-sm text-green-600 mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['total_orders'] }}</p>
                <p class="text-xs text-green-600 mt-1">Pesanan selesai</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.2s">
                <p class="text-sm text-green-600 mb-1">Produk Terlaris</p>
                <p class="text-lg font-bold text-green-900 line-clamp-2">{{ $stats['best_selling_product'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.3s">
                <p class="text-sm text-green-600 mb-1">Rata-rata per Pesanan</p>
                <p class="text-3xl font-bold text-green-900">Rp {{ number_format($stats['avg_per_order'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Monthly Sales Chart --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Grafik Penjualan Bulanan</h3>
                <div class="h-64 flex flex-col justify-end">
                    @php
                        $maxSales = $monthlySales->max('sales') ?: 1;
                    @endphp
                    <div class="flex items-end justify-between gap-2 h-full">
                        @foreach($monthlySales as $data)
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-green-200 rounded-t-lg relative group" style="height: {{ ($data['sales'] / $maxSales) * 100 }}%">
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                        Rp {{ number_format($data['sales'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <span class="text-xs text-green-600 mt-2">{{ $data['month'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Top Products Chart --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Produk Terlaris</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $index => $item)
                        @if($item->product)
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold text-green-900 line-clamp-1">{{ $item->product->name }}</span>
                                    <span class="text-sm text-green-600">{{ $item->total_sold }} terjual</span>
                                </div>
                                <div class="w-full bg-green-100 rounded-full h-3">
                                    @php
                                        $maxSold = $topProducts->max('total_sold') ?: 1;
                                        $percentage = ($item->total_sold / $maxSold) * 100;
                                    @endphp
                                    <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                                <p class="text-xs text-green-600">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</p>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-12 text-green-600">
                            <p>Belum ada data penjualan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sales Table --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
            <h3 class="text-xl font-bold text-green-900 mb-4">Rincian Penjualan</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Order Number</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Harga Satuan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-green-100">
                        @forelse($salesDetails as $item)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-4 text-sm text-green-900">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-green-600">
                                    {{ $item->order->order_number }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-green-100 flex-shrink-0">
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-semibold text-green-900">{{ $item->product->name }}</p>
                                            <p class="text-xs text-green-600">{{ $item->product->category }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-green-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm text-green-900">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-green-900">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-green-600">
                                    Belum ada data penjualan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($salesDetails->hasPages())
                <div class="mt-4">
                    {{ $salesDetails->links() }}
                </div>
            @endif
        </div>
    </div>
    
    @push('styles')
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @endpush
@endsection
