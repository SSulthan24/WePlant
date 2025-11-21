@extends('layouts.dashboard')

@section('title', 'Tambah User | WePlan(t)')
@section('page-title', 'Tambah User')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Tambah Pengguna Baru</h2>
                    <p class="text-green-50">Buat akun pengguna baru untuk platform WePlan(t)</p>
                </div>
                <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-green-700 font-medium mb-2">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Role *</label>
                        <select name="role" required
                                class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="farmer" {{ old('role') === 'farmer' ? 'selected' : '' }}>Petani</option>
                            <option value="partner" {{ old('role') === 'partner' ? 'selected' : '' }}>Mitra</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Password *</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-green-700 font-medium mb-2">Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    </div>
                </div>

                {{-- Additional fields for farmer --}}
                <div id="farmerFields" class="hidden space-y-6 border-t border-green-200 pt-6">
                    <h3 class="text-lg font-bold text-green-900">Informasi Kebun (Opsional)</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-green-700 font-medium mb-2">Luas Lahan (ha)</label>
                            <input type="number" name="land_area" value="{{ old('land_area') }}" step="0.01" min="0"
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('land_area')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-green-700 font-medium mb-2">Lokasi Kebun</label>
                            <input type="text" name="garden_location" value="{{ old('garden_location') }}"
                                   class="w-full px-4 py-3 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            @error('garden_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-6 border-t border-green-200">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                        Simpan User
                    </button>
                    <a href="{{ route('admin.users') }}" class="px-6 py-3 border border-green-300 text-green-700 rounded-lg hover:bg-green-50 transition font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelector('select[name="role"]').addEventListener('change', function() {
            const farmerFields = document.getElementById('farmerFields');
            if (this.value === 'farmer') {
                farmerFields.classList.remove('hidden');
            } else {
                farmerFields.classList.add('hidden');
            }
        });
        
        // Show fields if role is already farmer (on error)
        @if(old('role') === 'farmer')
            document.getElementById('farmerFields').classList.remove('hidden');
        @endif
    </script>
    @endpush
@endsection



