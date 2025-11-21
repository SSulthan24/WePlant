@extends('layouts.app')

@section('title', 'Checkout | WePlan(t)')

@section('content')
    <section class="bg-green-50 py-16 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 md:px-6">
            <h1 class="text-4xl font-bold text-green-900 mb-8">Checkout</h1>
            
            <form action="{{ route('checkout.store') }}" method="POST" class="grid lg:grid-cols-3 gap-8">
                @csrf
                
                {{-- Order Items --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Shipping Information --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                        <h2 class="text-2xl font-bold text-green-900 mb-6">Informasi Pengiriman</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-green-700 font-medium mb-2">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ auth()->user()->name ?? old('name') }}" required
                                       class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-green-700 font-medium mb-2">Email *</label>
                                <input type="email" name="email" value="{{ auth()->user()->email ?? old('email') }}" required
                                       class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-green-700 font-medium mb-2">Nomor Telepon *</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                       class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-green-700 font-medium mb-2">Alamat Lengkap *</label>
                                <textarea name="address" rows="3" required
                                          class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-green-700 font-medium mb-2">Kota *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                           class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-green-700 font-medium mb-2">Kode Pos *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                           class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Payment Method --}}
                    <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                        <h2 class="text-2xl font-bold text-green-900 mb-6">Metode Pembayaran</h2>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-green-300 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                <input type="radio" name="payment_method" value="transfer" {{ old('payment_method') === 'transfer' ? 'checked' : '' }} required class="mr-3">
                                <div>
                                    <p class="font-semibold text-green-900">Transfer Bank</p>
                                    <p class="text-sm text-green-600">Transfer melalui bank BCA, Mandiri, atau BRI</p>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border-2 border-green-300 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                <input type="radio" name="payment_method" value="bank" {{ old('payment_method') === 'bank' ? 'checked' : '' }} required class="mr-3">
                                <div>
                                    <p class="font-semibold text-green-900">Virtual Account</p>
                                    <p class="text-sm text-green-600">Bayar melalui virtual account</p>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border-2 border-green-300 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                <input type="radio" name="payment_method" value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }} required class="mr-3">
                                <div>
                                    <p class="font-semibold text-green-900">Cash on Delivery (COD)</p>
                                    <p class="text-sm text-green-600">Bayar saat barang diterima</p>
                                </div>
                            </label>
                            @error('payment_method')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                        <h2 class="text-2xl font-bold text-green-900 mb-6">Ringkasan Pesanan</h2>
                        <div class="space-y-3 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between text-sm text-green-700">
                                    <span>{{ $item['product']->name }} (x{{ $item['quantity'] }})</span>
                                    <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <div class="border-t border-green-200 pt-3 mt-3">
                                <div class="flex justify-between text-lg font-bold text-green-900">
                                    <span>Total</span>
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-105">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

