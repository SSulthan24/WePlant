@extends('layouts.dashboard')

@section('title', 'Buat Artikel | WePlan(t)')
@section('page-title', 'Buat Artikel')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Buat Artikel Baru</h2>
                    <p class="text-green-50">Buat artikel edukasi untuk petani</p>
                </div>
                <a href="{{ route('admin.articles') }}" class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-green-700 font-medium mb-2">Judul Artikel *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-green-700 font-medium mb-2">Konten Artikel *</label>
                    <textarea name="content" rows="10" required
                              class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-green-700 font-medium mb-2">Tag</label>
                        <input type="text" name="tag" value="{{ old('tag') }}" placeholder="Contoh: Teknologi, Panduan"
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('tag')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Status *</label>
                        <select name="status" required
                                class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-green-700 font-medium mb-2">Gambar Artikel</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-green-600">Maksimal 2MB. Format: JPG, PNG</p>
                </div>

                <div class="flex gap-4 pt-6 border-t border-green-200">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                        Simpan Artikel
                    </button>
                    <a href="{{ route('admin.articles') }}" class="px-6 py-3 border border-green-300 text-green-700 rounded-lg hover:bg-green-50 transition font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection


