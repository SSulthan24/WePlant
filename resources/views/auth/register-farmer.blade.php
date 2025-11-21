@extends('layouts.app')

@section('title', 'Daftar Sebagai Petani | WePlan(t)')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-green-50 py-12 px-4">
        <div class="w-full max-w-lg">
            <div class="bg-green-600 rounded-3xl p-8 md:p-12 shadow-xl">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Daftar Sebagai Petani</h1>
                </div>

                {{-- Registration Form --}}
                <form method="POST" action="{{ route('register.farmer') }}" class="space-y-6">
                    @csrf

                    {{-- Full Name --}}
                    <div>
                        <label for="name" class="block text-white text-sm font-medium mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="John Wick"
                               class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 placeholder-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-white text-sm font-medium mb-2">
                            Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="test@example.com"
                               class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 placeholder-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-white text-sm font-medium mb-2">
                            Kata Sandi
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password"
                               class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 placeholder-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-white text-sm font-medium mb-2">
                            Ulangi Kata Sandi
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation"
                               class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 placeholder-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                               required>
                    </div>

                    {{-- Land Area --}}
                    <div>
                        <label for="land_area" class="block text-white text-sm font-medium mb-2">
                            Luas Lahan (ha)
                        </label>
                        <input type="number" 
                               id="land_area" 
                               name="land_area" 
                               value="{{ old('land_area') }}"
                               placeholder="Contoh: 2"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 placeholder-green-500 focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('land_area')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Garden Location --}}
                    <div>
                        <label for="garden_location" class="block text-white text-sm font-medium mb-2">
                            Lokasi Kebun
                        </label>
                        <button type="button" 
                                id="locationBtn"
                                class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 text-left hover:bg-green-100 transition">
                            Pilih Lokasi Kebun
                        </button>
                        <input type="hidden" 
                               id="garden_location" 
                               name="garden_location" 
                               value="{{ old('garden_location') }}">
                        @error('garden_location')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Terms Checkbox --}}
                    <div class="flex items-start">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms"
                               class="mt-1 w-4 h-4 rounded-full bg-green-50 border-green-300 text-green-900 focus:ring-green-400"
                               required>
                        <label for="terms" class="ml-2 text-sm text-white">
                            Saya menyetujui Ketentuan Layanan & Kebijakan Privasi
                        </label>
                    </div>
                    @error('terms')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full bg-green-50 text-green-900 font-semibold py-3 rounded-lg hover:bg-green-100 transition">
                        Daftar Sebagai Petani
                    </button>
                </form>

                {{-- Footer Note --}}
                <div class="mt-6 text-xs text-green-200 text-center">
                    <p>
                        Dengan masuk, Anda menyetujui 
                        <a href="#" class="text-white hover:underline">Ketentuan Layanan</a> 
                        dan 
                        <a href="#" class="text-white hover:underline">Kebijakan Privasi</a>.
                    </p>
                </div>

                {{-- Back to Login --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-white hover:text-green-200 transition">
                        ← Kembali ke Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('locationBtn').addEventListener('click', function(e) {
            e.preventDefault();
            // Placeholder for location picker - will be implemented with map integration later
            const location = prompt('Masukkan lokasi kebun (contoh: Jl. Sawit No. 123, Jakarta):');
            if (location) {
                document.getElementById('garden_location').value = location;
                this.textContent = location;
                this.classList.remove('text-green-900');
                this.classList.add('text-green-700');
            }
        });
    </script>
    @endpush
@endsection

