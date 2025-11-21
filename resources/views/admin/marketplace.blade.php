@extends('layouts.dashboard')

@section('title', 'Marketplace | WePlan(t)')
@section('page-title', 'Marketplace')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Kelola Marketplace</h2>
            <p class="text-green-50">Monitor dan kelola aktivitas marketplace</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in">
                <p class="text-sm text-green-600 mb-1">Total Produk</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['total_products'] }}</p>
                <p class="text-xs text-green-600 mt-1">Produk aktif di toko</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.1s">
                <p class="text-sm text-green-600 mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['total_orders'] }}</p>
                <p class="text-xs text-green-600 mt-1">Semua pesanan</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.2s">
                <p class="text-sm text-green-600 mb-1">Pendapatan</p>
                <p class="text-3xl font-bold text-green-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p class="text-xs text-green-600 mt-1">Dari pesanan selesai</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.3s">
                <p class="text-sm text-green-600 mb-1">Mitra Aktif</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['active_partners'] }}</p>
                <p class="text-xs text-green-600 mt-1">Dengan produk aktif</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            {{-- Recent Orders --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Pesanan Terbaru</h3>
                <div class="space-y-3">
                    @forelse($recentOrders as $order)
                        <div class="border border-green-200 rounded-lg p-4 hover:bg-green-50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-green-900">{{ $order->order_number }}</p>
                                    <p class="text-sm text-green-600">{{ $order->name }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'shipped' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    @if($order->status === 'pending')
                                        Menunggu
                                    @elseif($order->status === 'processing')
                                        Diproses
                                    @elseif($order->status === 'shipped')
                                        Dikirim
                                    @elseif($order->status === 'completed')
                                        Selesai
                                    @else
                                        Dibatalkan
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-green-600">{{ $order->items->count() }} item</span>
                                <span class="font-semibold text-green-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-xs text-green-500 mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-12 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-lg">Belum ada pesanan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Top Selling Products --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Produk Terlaris</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $index => $item)
                        @if($item->product)
                            <div class="flex items-center gap-4 p-3 border border-green-200 rounded-lg hover:bg-green-50 transition">
                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-green-100 flex-shrink-0">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-green-900 truncate">{{ $item->product->name }}</p>
                                    <div class="flex items-center gap-4 text-sm text-green-600 mt-1">
                                        <span>{{ $item->total_sold }} terjual</span>
                                        <span>•</span>
                                        <span>Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-green-600">#{{ $index + 1 }}</span>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-12 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="text-lg">Belum ada data penjualan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Orders by Status Chart --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
            <h3 class="text-xl font-bold text-green-900 mb-4">Distribusi Status Pesanan</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">{{ $ordersByStatus['pending'] ?? 0 }}</p>
                    <p class="text-sm text-gray-600 mt-1">Menunggu</p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-2xl font-bold text-yellow-900">{{ $ordersByStatus['processing'] ?? 0 }}</p>
                    <p class="text-sm text-yellow-600 mt-1">Diproses</p>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-900">{{ $ordersByStatus['shipped'] ?? 0 }}</p>
                    <p class="text-sm text-blue-600 mt-1">Dikirim</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-900">{{ $ordersByStatus['completed'] ?? 0 }}</p>
                    <p class="text-sm text-green-600 mt-1">Selesai</p>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <p class="text-2xl font-bold text-red-900">{{ $ordersByStatus['cancelled'] ?? 0 }}</p>
                    <p class="text-sm text-red-600 mt-1">Dibatalkan</p>
                </div>
            </div>
        </div>
    </div>
@endsection
