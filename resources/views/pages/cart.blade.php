@extends('layouts.app')

@section('title', 'Keranjang | WePlan(t)')

@section('content')
    <section class="bg-green-50 py-16 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 md:px-6">
            <h1 class="text-4xl font-bold text-green-900 mb-8">Keranjang Belanja</h1>
            
            @if(count($cartItems) > 0)
                <div class="grid lg:grid-cols-3 gap-8">
                    {{-- Cart Items --}}
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cartItems as $id => $item)
                            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-6 animate-fade-in">
                                <div class="w-full md:w-32 h-32 rounded-xl overflow-hidden bg-green-100 flex-shrink-0">
                                    <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-xl font-semibold text-green-900 mb-2">{{ $item['product']->name }}</h3>
                                        <p class="text-green-600 mb-4">{{ $item['product']->category }}</p>
                                        <p class="text-2xl font-bold text-green-700">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center gap-4 mt-4">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <label class="text-green-700 font-medium">Qty:</label>
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}"
                                                   class="w-20 px-3 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                Update
                                            </button>
                                        </form>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                            <h2 class="text-2xl font-bold text-green-900 mb-6">Ringkasan Pesanan</h2>
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-green-700">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-green-700">
                                    <span>Ongkir</span>
                                    <span>Dihitung saat checkout</span>
                                </div>
                                <div class="border-t border-green-200 pt-4">
                                    <div class="flex justify-between text-xl font-bold text-green-900">
                                        <span>Total</span>
                                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('checkout') }}" 
                               class="block w-full bg-green-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-105">
                                Lanjut ke Checkout
                            </a>
                            <a href="{{ route('shop') }}" 
                               class="block w-full text-center py-3 text-green-600 hover:text-green-700 transition mt-3">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-green-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-green-600 text-xl mb-4">Keranjang Anda kosong</p>
                    <a href="{{ route('shop') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection



