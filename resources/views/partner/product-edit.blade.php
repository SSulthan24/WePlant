@extends('layouts.dashboard')

@section('title', 'Edit Produk | WePlan(t)')
@section('page-title', 'Edit Produk')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Edit Produk</h2>
                    <p class="text-green-50">Perbarui informasi produk</p>
                </div>
                <a href="{{ route('partner.products') }}" class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
            <form action="{{ route('partner.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-green-700 font-medium mb-2">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-green-700 font-medium mb-2">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Kategori *</label>
                        <select name="category" required
                                class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            <option value="Pupuk" {{ old('category', $product->category) === 'Pupuk' ? 'selected' : '' }}>Pupuk</option>
                            <option value="Bibit" {{ old('category', $product->category) === 'Bibit' ? 'selected' : '' }}>Bibit</option>
                            <option value="Pestisida" {{ old('category', $product->category) === 'Pestisida' ? 'selected' : '' }}>Pestisida</option>
                            <option value="Alat" {{ old('category', $product->category) === 'Alat' ? 'selected' : '' }}>Alat</option>
                            <option value="Lainnya" {{ old('category', $product->category) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Gambar Produk</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ $product->image }}" alt="Current Image" class="w-32 h-32 object-cover rounded-lg border border-green-300">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-green-600">Kosongkan jika tidak ingin mengubah gambar</p>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">
                        <strong>Catatan:</strong> Jika produk sudah disetujui, status akan kembali menjadi "Menunggu" setelah Anda mengedit produk ini.
                    </p>
                </div>

                <div class="flex gap-4 pt-6 border-t border-green-200">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('partner.products') }}" class="px-6 py-3 border border-green-300 text-green-700 rounded-lg hover:bg-green-50 transition font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection



