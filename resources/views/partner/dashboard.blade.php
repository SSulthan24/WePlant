@extends('layouts.dashboard')

@section('title', 'Dashboard Mitra | WePlan(t)')
@section('page-title', 'Welcome')

@section('content')
    {{-- Top Row Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl p-6 shadow-lg animate-fade-in">
            <h3 class="text-lg font-semibold text-green-600 mb-4">Total Produk</h3>
            <p class="text-3xl font-bold text-green-900 mb-2">{{ $stats['total_products'] }}</p>
            <a href="{{ route('partner.products') }}" class="text-sm text-green-600 hover:text-green-700">Lihat semua →</a>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.1s">
            <h3 class="text-lg font-semibold text-green-600 mb-4">Produk Disetujui</h3>
            <p class="text-3xl font-bold text-green-900 mb-2">{{ $stats['approved_products'] }}</p>
            <p class="text-sm text-green-600">Aktif di toko</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.2s">
            <h3 class="text-lg font-semibold text-yellow-600 mb-4">Menunggu Persetujuan</h3>
            <p class="text-3xl font-bold text-yellow-900 mb-2">{{ $stats['pending_products'] }}</p>
            <p class="text-sm text-yellow-600">Dalam review admin</p>
        </div>
    </div>
    
    @if($stats['pending_products'] > 0)
        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg">
            <p class="font-semibold">Anda memiliki {{ $stats['pending_products'] }} produk yang menunggu persetujuan admin.</p>
        </div>
    @endif

    {{-- Bottom Row Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Sales Graph --}}
        <div class="bg-green-200 rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-green-900 mb-4">Grafik Penjualan</h3>
            <div class="h-64 flex items-center justify-center">
                <div class="w-full h-full flex flex-col justify-end">
                    {{-- Simple bar chart representation --}}
                    <div class="flex items-end justify-between h-full gap-2">
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-green-700 rounded-t" style="height: 40%;"></div>
                            <span class="text-xs text-green-700 mt-2">Jan</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-green-700 rounded-t" style="height: 60%;"></div>
                            <span class="text-xs text-green-700 mt-2">Feb</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-green-700 rounded-t" style="height: 100%;"></div>
                            <span class="text-xs text-green-700 mt-2">Mar</span>
                        </div>
                    </div>
                    <div class="flex justify-between text-xs text-green-700 mt-2">
                        <span>Rp4.000.000</span>
                        <span>Rp2.000.000</span>
                        <span>Rp0</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Best Selling Products --}}
        <div class="bg-green-200 rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-green-900 mb-4">Produk Terlaris</h3>
            <div class="space-y-4">
                @php
                    $products = [
                        ['name' => 'Produk xx', 'percentage' => 30],
                        ['name' => 'Produk xx', 'percentage' => 100],
                        ['name' => 'Produk xx', 'percentage' => 70],
                        ['name' => 'Produk xx', 'percentage' => 50],
                    ];
                @endphp
                @foreach ($products as $index => $product)
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-green-900 w-8">{{ $index + 1 }}.</span>
                        <span class="text-sm text-green-800 flex-1">{{ $product['name'] }}</span>
                        <div class="flex-1 bg-green-300 rounded-full h-3">
                            <div class="bg-green-700 h-3 rounded-full" style="width: {{ $product['percentage'] }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

