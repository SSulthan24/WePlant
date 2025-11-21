@extends('layouts.dashboard')

@section('title', 'Detail User | WePlan(t)')
@section('page-title', 'Detail User')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Detail Pengguna</h2>
                    <p class="text-green-50">Informasi lengkap pengguna</p>
                </div>
                <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- User Info --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <div class="flex items-center gap-6 mb-6">
                        <div class="w-20 h-20 rounded-full bg-green-200 flex items-center justify-center">
                            <span class="text-3xl text-green-700 font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-green-900">{{ $user->name }}</h3>
                            <p class="text-green-600">{{ $user->email }}</p>
                            <span class="inline-block mt-2 px-4 py-1 rounded-full text-sm font-semibold
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                   ($user->role === 'farmer' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'farmer' ? 'Petani' : 'Mitra') }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-green-600 mb-1">Email</p>
                            <p class="font-semibold text-green-900">{{ $user->email }}</p>
                        </div>
                        @if($user->phone)
                            <div>
                                <p class="text-sm text-green-600 mb-1">Nomor Telepon</p>
                                <p class="font-semibold text-green-900">{{ $user->phone }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-green-600 mb-1">Bergabung Sejak</p>
                            <p class="font-semibold text-green-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if($user->role === 'farmer')
                            @if($user->land_area)
                                <div>
                                    <p class="text-sm text-green-600 mb-1">Luas Lahan</p>
                                    <p class="font-semibold text-green-900">{{ $user->land_area }} ha</p>
                                </div>
                            @endif
                            @if($user->garden_location)
                                <div>
                                    <p class="text-sm text-green-600 mb-1">Lokasi Kebun</p>
                                    <p class="font-semibold text-green-900">{{ $user->garden_location }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-center font-semibold">
                            Edit User
                        </a>
                        <a href="mailto:{{ $user->email }}" class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-semibold">
                            Kirim Email
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                                    Hapus User
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-semibold">
                                Tidak dapat menghapus akun sendiri
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

