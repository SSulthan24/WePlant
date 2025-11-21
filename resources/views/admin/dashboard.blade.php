@extends('layouts.dashboard')

@section('title', 'Dashboard Admin | WePlan(t)')
@section('page-title', 'Welcome')

@section('content')
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg animate-fade-in">
                    <h3 class="text-lg font-semibold text-green-600 mb-2">Total User</h3>
                    <p class="text-3xl font-bold text-green-900">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.1s">
                    <h3 class="text-lg font-semibold text-green-600 mb-2">Total Petani</h3>
                    <p class="text-3xl font-bold text-green-900">{{ $stats['total_farmers'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.2s">
                    <h3 class="text-lg font-semibold text-green-600 mb-2">Total Mitra</h3>
                    <p class="text-3xl font-bold text-green-900">{{ $stats['total_partners'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.3s">
                    <h3 class="text-lg font-semibold text-green-600 mb-2">Total Produk</h3>
                    <p class="text-3xl font-bold text-green-900">{{ $stats['total_products'] }}</p>
                </div>
            </div>
            
            @if($stats['pending_products'] > 0)
                <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg">
                    <p class="font-semibold">Ada {{ $stats['pending_products'] }} produk yang menunggu persetujuan. <a href="{{ route('admin.products') }}" class="underline">Lihat sekarang</a></p>
                </div>
            @endif

    {{-- Sales Graph --}}
    <div class="bg-green-200 rounded-2xl p-6 mb-6">
        <h3 class="text-xl font-semibold text-green-900 mb-4">Grafik Penjualan</h3>
        <div class="h-64 flex items-center justify-center text-green-600">
            <p>Grafik akan ditampilkan di sini</p>
        </div>
    </div>

    {{-- Registration Graphs --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-green-200 rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-green-900 mb-4">Grafik Pendaftar Petani</h3>
            <div class="h-64 flex items-center justify-center text-green-600">
                <p>Grafik akan ditampilkan di sini</p>
            </div>
        </div>
        <div class="bg-green-200 rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-green-900 mb-4">Grafik Pendaftar Mitra</h3>
            <div class="h-64 flex items-center justify-center text-green-600">
                <p>Grafik akan ditampilkan di sini</p>
            </div>
        </div>
    </div>
@endsection

