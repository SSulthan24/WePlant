@extends('layouts.dashboard')

@section('title', 'Pengaturan Akun | WePlan(t)')
@section('page-title', 'Pengaturan Akun')

@section('content')
    <div class="space-y-6">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Pengaturan Akun</h2>
            <p class="text-green-50">Kelola informasi profil dan keamanan akun Anda</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Profile Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <h3 class="text-xl font-bold text-green-900 mb-6">Informasi Profil</h3>
                    <form action="{{ route('farmer.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-green-700 font-medium mb-2">Nama Lengkap *</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Luas Lahan (Hektar)</label>
                            <input type="number" step="0.01" name="land_area" value="{{ old('land_area', auth()->user()->land_area) }}" 
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('land_area')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Lokasi Kebun</label>
                            <input type="text" name="garden_location" value="{{ old('garden_location', auth()->user()->garden_location) }}" 
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('garden_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-6 border-t border-green-200">
                            <h3 class="text-xl font-bold text-green-900 mb-6">Ubah Kata Sandi</h3>
                            
                            <div>
                                <label class="block text-green-700 font-medium mb-2">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" 
                                       class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-green-700 font-medium mb-2">Kata Sandi Baru</label>
                                <input type="password" name="password" 
                                       class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-green-700 font-medium mb-2">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-105">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Account Info --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Informasi Akun</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-green-600">Role</p>
                            <p class="font-semibold text-green-900">Petani</p>
                        </div>
                        <div>
                            <p class="text-sm text-green-600">Bergabung Sejak</p>
                            <p class="font-semibold text-green-900">{{ auth()->user()->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Foto Profil</h3>
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full bg-green-200 flex items-center justify-center mb-4 overflow-hidden border-2 border-green-300">
                            @if(auth()->user()->avatar && file_exists(public_path('storage/' . auth()->user()->avatar)))
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div style="display: none;" class="w-full h-full items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <form action="{{ route('farmer.settings.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
                            @csrf
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="this.form.submit()">
                            <label for="avatar" class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold text-center cursor-pointer">
                                Ubah Foto
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


