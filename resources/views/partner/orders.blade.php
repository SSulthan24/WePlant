@extends('layouts.dashboard')

@section('title', 'Pesanan | WePlan(t)')
@section('page-title', 'Pesanan')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Pesanan Saya</h2>
            <p class="text-green-50">Lihat semua pesanan untuk produk Anda</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-lg">
                <p class="text-xs text-green-600 mb-1">Total</p>
                <p class="text-2xl font-bold text-green-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-lg">
                <p class="text-xs text-yellow-600 mb-1">Menunggu</p>
                <p class="text-2xl font-bold text-yellow-900">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-lg">
                <p class="text-xs text-blue-600 mb-1">Diproses</p>
                <p class="text-2xl font-bold text-blue-900">{{ $stats['processing'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-lg">
                <p class="text-xs text-indigo-600 mb-1">Dikirim</p>
                <p class="text-2xl font-bold text-indigo-900">{{ $stats['shipped'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-lg">
                <p class="text-xs text-green-600 mb-1">Selesai</p>
                <p class="text-2xl font-bold text-green-900">{{ $stats['completed'] }}</p>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="flex gap-2 overflow-x-auto">
                <a href="{{ route('partner.orders', ['status' => 'all']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold whitespace-nowrap transition
                   {{ ($status ?? 'all') === 'all' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                    Semua
                </a>
                <a href="{{ route('partner.orders', ['status' => 'pending']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold whitespace-nowrap transition
                   {{ ($status ?? '') === 'pending' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                    Menunggu
                </a>
                <a href="{{ route('partner.orders', ['status' => 'processing']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold whitespace-nowrap transition
                   {{ ($status ?? '') === 'processing' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                    Diproses
                </a>
                <a href="{{ route('partner.orders', ['status' => 'shipped']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold whitespace-nowrap transition
                   {{ ($status ?? '') === 'shipped' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                    Dikirim
                </a>
                <a href="{{ route('partner.orders', ['status' => 'completed']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold whitespace-nowrap transition
                   {{ ($status ?? '') === 'completed' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                    Selesai
                </a>
            </div>
        </div>

        {{-- Orders List --}}
        <div class="space-y-4">
            @forelse($orders as $index => $order)
                @php
                    // Get items from this partner's products only
                    $partnerItems = $order->items->filter(function($item) {
                        return $item->product && $item->product->partner_id === auth()->id();
                    });
                    $partnerTotal = $partnerItems->sum('subtotal');
                    $itemCount = $partnerItems->sum('quantity');
                @endphp
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-3">
                                <h3 class="text-xl font-bold text-green-900">Pesanan {{ $order->order_number }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'shipped' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
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
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-green-600">Pelanggan</p>
                                    <p class="font-semibold text-green-900">{{ $order->name }}</p>
                                </div>
                                <div>
                                    <p class="text-green-600">Tanggal</p>
                                    <p class="font-semibold text-green-900">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-green-600">Jumlah Item</p>
                                    <p class="font-semibold text-green-900">{{ $itemCount }} produk</p>
                                </div>
                                <div>
                                    <p class="text-green-600">Total</p>
                                    <p class="font-semibold text-green-900">Rp {{ number_format($partnerTotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('partner.orders.show', $order->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                                Detail
                            </a>
                            @if($order->status === 'pending')
                                <form action="{{ route('partner.orders.update-status', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                        Proses
                                    </button>
                                </form>
                            @elseif($order->status === 'processing')
                                <form action="{{ route('partner.orders.update-status', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition font-semibold">
                                        Kirim
                                    </button>
                                </form>
                            @elseif($order->status === 'shipped')
                                <form action="{{ route('partner.orders.update-status', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold">
                                        Selesai
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-green-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-green-600 text-lg mb-4">Belum ada pesanan</p>
                </div>
            @endforelse
        </div>

        @if($orders->hasPages())
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
