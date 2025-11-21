@extends('layouts.dashboard')

@section('title', 'Edit Kebun | WePlan(t)')
@section('page-title', 'Edit Kebun')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Kelola Data Kebun</h2>
            <p class="text-green-50">Perbarui informasi kebun kelapa sawit Anda</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <form action="{{ route('farmer.garden.update') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-green-700 font-medium mb-2">Luas Lahan (ha)</label>
                            <input type="number" name="land_area" value="{{ old('land_area', auth()->user()->land_area ?? '') }}" 
                                   step="0.01" min="0"
                                   placeholder="Contoh: 2.5"
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('land_area')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Lokasi Kebun</label>
                            <input type="text" name="garden_location" value="{{ old('garden_location', auth()->user()->garden_location ?? '') }}" 
                                   placeholder="Contoh: Jl. Sawit No. 123, Jakarta"
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('garden_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Koordinat GPS (Opsional)</label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="latitude" value="{{ old('latitude') }}" 
                                       placeholder="Latitude"
                                       class="px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <input type="text" name="longitude" value="{{ old('longitude') }}" 
                                       placeholder="Longitude"
                                       class="px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Jenis Tanah</label>
                            <select name="soil_type" class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                <option value="">Pilih Jenis Tanah</option>
                                <option value="tanah_latosol">Tanah Latosol</option>
                                <option value="tanah_podzolik">Tanah Podzolik</option>
                                <option value="tanah_alluvial">Tanah Alluvial</option>
                                <option value="tanah_lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Tahun Tanam</label>
                            <input type="number" name="planting_year" value="{{ old('planting_year') }}" 
                                   min="1900" max="{{ date('Y') }}"
                                   placeholder="Contoh: 2020"
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-105">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Map Preview --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Peta Kebun</h3>
                    <div class="aspect-square rounded-xl overflow-hidden bg-green-200">
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <p class="text-green-600 font-semibold">Peta akan muncul di sini</p>
                                <p class="text-sm text-green-500 mt-1">Setelah koordinat diisi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



