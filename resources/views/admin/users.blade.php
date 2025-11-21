@extends('layouts.dashboard')

@section('title', 'Kelola User | WePlan(t)')
@section('page-title', 'Kelola User')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Kelola Pengguna</h2>
            <p class="text-green-50">Kelola semua pengguna platform WePlan(t)</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-green-600 mb-1">Total User</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-green-600 mb-1">Petani</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['farmers'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-green-600 mb-1">Mitra</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['partners'] }}</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <p class="text-sm text-green-600 mb-1">Admin</p>
                <p class="text-3xl font-bold text-green-900">{{ $stats['admins'] }}</p>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-fade-in">
            <div class="p-6 border-b border-green-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-green-900">Daftar Pengguna</h3>
                    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                        + Tambah User
                    </a>
                    <form method="GET" action="{{ route('admin.users') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..." 
                               class="px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <select name="role" class="px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500" onchange="this.form.submit()">
                            <option value="Semua Role" {{ request('role') === 'Semua Role' || !request('role') ? 'selected' : '' }}>Semua Role</option>
                            <option value="farmer" {{ request('role') === 'farmer' ? 'selected' : '' }}>Petani</option>
                            <option value="partner" {{ request('role') === 'partner' ? 'selected' : '' }}>Mitra</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Cari
                        </button>
                        @if(request('search') || request('role'))
                            <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Bergabung</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-green-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center">
                                            <span class="text-green-700 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <span class="font-semibold text-green-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-green-700">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                           ($user->role === 'farmer' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'farmer' ? 'Petani' : 'Mitra') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-green-600">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-green-200">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

