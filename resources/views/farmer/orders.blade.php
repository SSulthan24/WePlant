@extends('layouts.dashboard')

@section('title', 'Riwayat Pesanan | WePlan(t)')
@section('page-title', 'Riwayat Pesanan')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Riwayat Pesanan</h2>
            <p class="text-green-50">Lihat semua pesanan yang telah Anda buat</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="flex gap-2 overflow-x-auto">
                <button class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold whitespace-nowrap">Semua</button>
                <button class="px-6 py-2 bg-green-100 text-green-700 rounded-lg font-semibold hover:bg-green-200 transition whitespace-nowrap">Menunggu</button>
                <button class="px-6 py-2 bg-green-100 text-green-700 rounded-lg font-semibold hover:bg-green-200 transition whitespace-nowrap">Diproses</button>
                <button class="px-6 py-2 bg-green-100 text-green-700 rounded-lg font-semibold hover:bg-green-200 transition whitespace-nowrap">Dikirim</button>
                <button class="px-6 py-2 bg-green-100 text-green-700 rounded-lg font-semibold hover:bg-green-200 transition whitespace-nowrap">Selesai</button>
            </div>
        </div>

        {{-- Orders List --}}
        <div class="space-y-4">
            @php
                $orders = [
                    ['id' => 'ORD-001', 'date' => now()->subDays(2), 'status' => 'Dikirim', 'total' => 250000, 'items' => 3],
                    ['id' => 'ORD-002', 'date' => now()->subDays(5), 'status' => 'Diproses', 'total' => 180000, 'items' => 2],
                    ['id' => 'ORD-003', 'date' => now()->subDays(10), 'status' => 'Selesai', 'total' => 320000, 'items' => 4],
                    ['id' => 'ORD-004', 'date' => now()->subDays(15), 'status' => 'Selesai', 'total' => 150000, 'items' => 1],
                ];
            @endphp
            @foreach($orders as $index => $order)
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-3">
                                <h3 class="text-xl font-bold text-green-900">Pesanan {{ $order['id'] }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $order['status'] === 'Selesai' ? 'bg-green-100 text-green-800' : 
                                       ($order['status'] === 'Dikirim' ? 'bg-blue-100 text-blue-800' : 
                                       ($order['status'] === 'Diproses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $order['status'] }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-green-600">Tanggal</p>
                                    <p class="font-semibold text-green-900">{{ $order['date']->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-green-600">Jumlah Item</p>
                                    <p class="font-semibold text-green-900">{{ $order['items'] }} produk</p>
                                </div>
                                <div>
                                    <p class="text-green-600">Total</p>
                                    <p class="font-semibold text-green-900">Rp {{ number_format($order['total'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                                Detail
                            </button>
                            @if($order['status'] === 'Dikirim')
                                <button class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                                    Lacak
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty State (if no orders) --}}
        @if(empty($orders))
            <div class="bg-white rounded-2xl p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-green-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-green-600 text-lg mb-4">Belum ada pesanan</p>
                <a href="{{ route('shop') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
@endsection



