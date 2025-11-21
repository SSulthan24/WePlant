@extends('layouts.dashboard')

@section('title', 'Laporan | WePlan(t)')
@section('page-title', 'Laporan')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Laporan & Analytics</h2>
                    <p class="text-green-50">Lihat laporan dan statistik platform</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="window.location.href='{{ route('admin.reports.export-pdf') }}'" class="px-6 py-3 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold whitespace-nowrap">
                        Export PDF
                    </button>
                    <button onclick="window.location.href='{{ route('admin.reports.export-excel') }}'" class="px-6 py-3 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold whitespace-nowrap">
                        Export Excel
                    </button>
                </div>
            </div>
        </div>

        {{-- Overview Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in">
                <p class="text-sm text-green-600 mb-1">Total Pengguna</p>
                <p class="text-3xl font-bold text-green-900">{{ $userStats['total'] }}</p>
                <p class="text-xs text-green-600 mt-1">Admin: {{ $userStats['admin'] }}, Petani: {{ $userStats['farmer'] }}, Mitra: {{ $userStats['partner'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.1s">
                <p class="text-sm text-green-600 mb-1">Total Produk</p>
                <p class="text-3xl font-bold text-green-900">{{ $productStats['total'] }}</p>
                <p class="text-xs text-green-600 mt-1">Disetujui: {{ $productStats['approved'] }}, Menunggu: {{ $productStats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.2s">
                <p class="text-sm text-green-600 mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-green-900">{{ $orderStats['total'] }}</p>
                <p class="text-xs text-green-600 mt-1">Selesai: {{ $orderStats['completed'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg animate-fade-in" style="animation-delay: 0.3s">
                <p class="text-sm text-green-600 mb-1">Total Pendapatan</p>
                <p class="text-3xl font-bold text-green-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="text-xs text-green-600 mt-1">{{ number_format($totalItemsSold, 0, ',', '.') }} item terjual</p>
            </div>
        </div>

        {{-- Report Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- User Statistics --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Statistik Pengguna</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <span class="text-green-700 font-medium">Total Pengguna</span>
                        <span class="text-2xl font-bold text-green-900">{{ $userStats['total'] }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <p class="text-xs text-blue-600">Admin</p>
                            <p class="text-xl font-bold text-blue-900">{{ $userStats['admin'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-xs text-green-600">Petani</p>
                            <p class="text-xl font-bold text-green-900">{{ $userStats['farmer'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <p class="text-xs text-yellow-600">Mitra</p>
                            <p class="text-xl font-bold text-yellow-900">{{ $userStats['partner'] }}</p>
                        </div>
                    </div>
                    <div class="h-48 flex flex-col justify-end">
                        @php
                            $maxUsers = $userGrowth->max('count') ?: 1;
                        @endphp
                        <div class="flex items-end justify-between gap-2">
                            @foreach($userGrowth as $data)
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-green-400 rounded-t-lg group relative" style="height: {{ ($data['count'] / $maxUsers) * 100 }}%">
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                            {{ $data['count'] }} user
                                        </div>
                                    </div>
                                    <span class="text-xs text-green-600 mt-2">{{ $data['month'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Statistics --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Statistik Produk</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-green-50 rounded-lg">
                            <p class="text-xs text-green-600">Disetujui</p>
                            <p class="text-2xl font-bold text-green-900">{{ $productStats['approved'] }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <p class="text-xs text-yellow-600">Menunggu</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $productStats['pending'] }}</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-lg">
                            <p class="text-xs text-red-600">Ditolak</p>
                            <p class="text-2xl font-bold text-red-900">{{ $productStats['rejected'] }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $productStats['total'] }}</p>
                        </div>
                    </div>
                    <div class="h-48 flex flex-col justify-end">
                        @php
                            $maxProducts = $productGrowth->max('count') ?: 1;
                        @endphp
                        <div class="flex items-end justify-between gap-2">
                            @foreach($productGrowth as $data)
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-blue-400 rounded-t-lg group relative" style="height: {{ ($data['count'] / $maxProducts) * 100 }}%">
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                            {{ $data['count'] }} produk
                                        </div>
                                    </div>
                                    <span class="text-xs text-green-600 mt-2">{{ $data['month'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Statistics --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Statistik Pesanan</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600">Menunggu</p>
                            <p class="text-xl font-bold text-gray-900">{{ $orderStats['pending'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <p class="text-xs text-yellow-600">Diproses</p>
                            <p class="text-xl font-bold text-yellow-900">{{ $orderStats['processing'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <p class="text-xs text-blue-600">Dikirim</p>
                            <p class="text-xl font-bold text-blue-900">{{ $orderStats['shipped'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-xs text-green-600">Selesai</p>
                            <p class="text-xl font-bold text-green-900">{{ $orderStats['completed'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <p class="text-xs text-red-600">Dibatalkan</p>
                            <p class="text-xl font-bold text-red-900">{{ $orderStats['cancelled'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-gray-100 rounded-lg">
                            <p class="text-xs text-gray-700">Total</p>
                            <p class="text-xl font-bold text-gray-900">{{ $orderStats['total'] }}</p>
                        </div>
                    </div>
                    <div class="h-48 flex flex-col justify-end">
                        @php
                            $maxOrders = $orderGrowth->max('count') ?: 1;
                        @endphp
                        <div class="flex items-end justify-between gap-2">
                            @foreach($orderGrowth as $data)
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-indigo-400 rounded-t-lg group relative" style="height: {{ ($data['count'] / $maxOrders) * 100 }}%">
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                            {{ $data['count'] }} pesanan
                                        </div>
                                    </div>
                                    <span class="text-xs text-green-600 mt-2">{{ $data['month'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Revenue Statistics --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                <h3 class="text-xl font-bold text-green-900 mb-4">Pendapatan</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">Total Pendapatan</p>
                        <p class="text-3xl font-bold text-green-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-600 mb-1">Total Item Terjual</p>
                        <p class="text-2xl font-bold text-blue-900">{{ number_format($totalItemsSold, 0, ',', '.') }}</p>
                        <p class="text-xs text-blue-600 mt-1">Dari semua pesanan selesai</p>
                    </div>
                    <div class="h-48 flex flex-col justify-end">
                        @php
                            $maxRevenue = $monthlyRevenue->max('revenue') ?: 1;
                        @endphp
                        <div class="flex items-end justify-between gap-2">
                            @foreach($monthlyRevenue as $data)
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-green-500 rounded-t-lg group relative" style="height: {{ ($data['revenue'] / $maxRevenue) * 100 }}%">
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                            Rp {{ number_format($data['revenue'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <span class="text-xs text-green-600 mt-2">{{ $data['month'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
