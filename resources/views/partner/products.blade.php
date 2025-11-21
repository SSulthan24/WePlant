@extends('layouts.dashboard')

@section('title', 'Kelola Produk | WePlan(t)')
@section('page-title', 'Kelola Produk')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Kelola Produk</h2>
                    <p class="text-green-50">Kelola produk Anda yang akan ditampilkan di toko</p>
                </div>
                <a href="{{ route('partner.products.create') }}" class="px-6 py-3 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                    + Tambah Produk
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-green-600 mb-1">Total Produk</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-green-600 mb-1">Disetujui</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['approved'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-yellow-600 mb-1">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-900">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-red-600 mb-1">Ditolak</p>
                <p class="text-3xl font-bold text-red-900">{{ $stats['rejected'] }}</p>
            </div>
        </div>

        {{-- Products List --}}
        <div class="grid gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 animate-fade-in">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-48 h-48 rounded-xl overflow-hidden bg-green-100 flex-shrink-0">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-green-900 mb-1">{{ $product->name }}</h3>
                                    <p class="text-green-600">{{ $product->category }}</p>
                                </div>
                                <span class="px-4 py-2 rounded-full text-sm font-semibold
                                    {{ $product->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($product->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->status === 'approved' ? 'Disetujui' : ($product->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                                </span>
                            </div>
                            <p class="text-green-700 mb-4">{{ Str::limit($product->description, 150) }}</p>
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-green-600">Harga</p>
                                    <p class="font-bold text-green-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-green-600">Stok</p>
                                    <p class="font-bold text-green-900">{{ $product->stock }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-green-600">Ditambahkan</p>
                                    <p class="font-bold text-green-900">{{ $product->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('partner.products.edit', $product->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                    Edit
                                </a>
                                <form action="{{ route('partner.products.destroy', $product->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-green-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <p class="text-green-600 text-lg mb-4">Belum ada produk</p>
                    <a href="{{ route('partner.products.create') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Tambah Produk Pertama
                    </a>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection


