@extends('layouts.app')

@section('title', 'Masuk | WePlan(t)')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-green-50 py-12 px-4">
        <div class="w-full max-w-lg">
            <div class="bg-green-600 rounded-3xl p-8 md:p-12 shadow-xl">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Masuk WePlan(t)</h1>
                    <p class="text-green-100 text-sm md:text-base">
                        Gunakan email/nomor HP dan kata sandi Anda.
                    </p>
                </div>

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email/Phone Input --}}
                    <div>
                        <label for="email" class="block text-white text-sm font-medium mb-2">
                            Email atau Nomor HP
                        </label>
                        <input type="text" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="test@example.com"
                               class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 placeholder-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-white text-sm font-medium">
                                Kata Sandi
                            </label>
                            <a href="#" class="text-sm text-white hover:text-green-200 transition">
                                Lupa kata sandi?
                            </a>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password"
                               class="w-full px-4 py-3 rounded-lg bg-green-50 text-green-900 placeholder-green-500 focus:outline-none focus:ring-2 focus:ring-green-400"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember"
                               class="w-4 h-4 rounded-full bg-green-50 border-green-300 text-green-900 focus:ring-green-400">
                        <label for="remember" class="ml-2 text-sm text-white">
                            Ingat saya
                        </label>
                    </div>

                    {{-- Login Button --}}
                    <button type="submit" 
                            class="w-full bg-green-50 text-green-900 font-semibold py-3 rounded-lg hover:bg-green-100 transition">
                        Masuk
                    </button>
                </form>

                {{-- Registration Section --}}
                <div class="mt-8 pt-8 border-t border-green-500">
                    <p class="text-white text-center mb-4">
                        Baru di WePlan(t)? Pilih peran untuk mendaftar:
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('register.farmer') }}" 
                           class="bg-green-50 text-green-900 font-semibold py-3 rounded-lg text-center hover:bg-green-100 transition">
                            Daftar Sebagai Petani
                        </a>
                        <a href="{{ route('register.partner') }}" 
                           class="bg-green-50 text-green-900 font-semibold py-3 rounded-lg text-center hover:bg-green-100 transition">
                            Daftar Sebagai Mitra
                        </a>
                    </div>
                </div>

                {{-- Footer Notes --}}
                <div class="mt-6 space-y-2 text-xs text-green-200 text-center">
                    <p>Pendaftaran vendor memerlukan verifikasi bisnis.</p>
                    <p>
                        Dengan masuk, Anda menyetujui 
                        <a href="#" class="text-white hover:underline">Ketentuan Layanan</a> 
                        dan 
                        <a href="#" class="text-white hover:underline">Kebijakan Privasi</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

