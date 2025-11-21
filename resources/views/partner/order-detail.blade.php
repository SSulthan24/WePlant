@extends('layouts.dashboard')

@section('title', 'Detail Pesanan | WePlan(t)')
@section('page-title', 'Detail Pesanan')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Detail Pesanan</h2>
                    <p class="text-green-50">Pesanan {{ $order->order_number }}</p>
                </div>
                <a href="{{ route('partner.orders') }}" class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Order Info --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Order Items --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <h3 class="text-xl font-bold text-green-900 mb-4">Item Pesanan</h3>
                    <div class="space-y-4">
                        @php
                            $partnerItems = $order->items->filter(function($item) {
                                return $item->product && $item->product->partner_id === auth()->id();
                            });
                        @endphp
                        @foreach($partnerItems as $item)
                            <div class="flex gap-4 p-4 border border-green-200 rounded-lg">
                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-green-100 flex-shrink-0">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-green-900">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-green-600">{{ $item->product->category }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-sm text-green-600">Qty: {{ $item->quantity }}</span>
                                        <span class="font-bold text-green-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <h3 class="text-xl font-bold text-green-900 mb-4">Informasi Pelanggan</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-green-600">Nama</p>
                            <p class="font-semibold text-green-900">{{ $order->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-green-600">Email</p>
                            <p class="font-semibold text-green-900">{{ $order->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-green-600">Telepon</p>
                            <p class="font-semibold text-green-900">{{ $order->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-green-600">Metode Pembayaran</p>
                            <p class="font-semibold text-green-900">
                                @if($order->payment_method === 'transfer')
                                    Transfer Bank
                                @elseif($order->payment_method === 'bank')
                                    Virtual Account
                                @else
                                    COD
                                @endif
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-green-600">Alamat</p>
                            <p class="font-semibold text-green-900">{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in sticky top-6">
                    <h3 class="text-xl font-bold text-green-900 mb-4">Ringkasan Pesanan</h3>
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="text-green-600">Status</span>
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
                        <div class="flex justify-between">
                            <span class="text-green-600">Tanggal Pesanan</span>
                            <span class="font-semibold text-green-900">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-600">Jumlah Item</span>
                            <span class="font-semibold text-green-900">{{ $partnerItems->sum('quantity') }}</span>
                        </div>
                        <div class="border-t border-green-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-green-900">Total</span>
                                <span class="text-lg font-bold text-green-900">Rp {{ number_format($partnerItems->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Update Status --}}
                    @if($order->status !== 'completed' && $order->status !== 'cancelled')
                        <form action="{{ route('partner.orders.update-status', $order->id) }}" method="POST" class="space-y-2">
                            @csrf
                            @method('PUT')
                            <label class="block text-sm font-semibold text-green-700 mb-2">Ubah Status</label>
                            <select name="status" onchange="this.form.submit()" 
                                    class="w-full px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition font-semibold">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


