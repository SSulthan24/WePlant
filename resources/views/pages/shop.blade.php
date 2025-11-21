@extends('layouts.app')

@section('title', 'Toko | WePlan(t)')

@section('content')
    {{-- Hero Banner --}}
    <section class="bg-gradient-to-br from-green-400 via-green-500 to-green-600 py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse delay-1000"></div>
        </div>
        <div class="max-w-6xl mx-auto px-4 md:px-6 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 animate-fade-in-down">Toko WePlan(t)</h1>
            <p class="text-xl text-green-50 mb-8 animate-fade-in-up">
                Produk agrikultur berkualitas untuk mendukung produktivitas kebun kelapa sawit Anda
            </p>
        </div>
    </section>

    {{-- Filters --}}
    <section class="bg-white border-b border-green-200 sticky top-16 z-10 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 md:px-6 py-4">
            <form method="GET" action="{{ route('shop') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari produk..." 
                           class="w-full px-4 py-2 rounded-lg border border-green-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>
                <select name="category" class="px-4 py-2 rounded-lg border border-green-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-105">
                    Cari
                </button>
            </form>
        </div>
    </section>

    {{-- Products Grid --}}
    <section class="bg-green-50 py-16">
        <div class="max-w-6xl mx-auto px-4 md:px-6">
            @if($products->count() > 0)
                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in">
                            <div class="relative aspect-square overflow-hidden bg-green-100">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                @if($product->stock < 10)
                                    <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                        Stok Terbatas
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 space-y-3">
                                <div>
                                    <h3 class="font-semibold text-green-900 line-clamp-2 min-h-[3rem]">{{ $product->name }}</h3>
                                    <p class="text-xs text-green-600 mt-1">{{ $product->category }}</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-xl font-bold text-green-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <span class="text-xs text-green-600">Stok: {{ $product->stock }}</span>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-green-600 text-lg">Produk tidak ditemukan</p>
                </div>
            @endif
        </div>
    </section>

    @push('styles')
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fade-in-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .animate-fade-in-down {
            animation: fade-in-down 0.8s ease-out;
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out 0.2s both;
        }
        
        .delay-1000 {
            animation-delay: 1s;
        }
    </style>
    @endpush
@endsection
