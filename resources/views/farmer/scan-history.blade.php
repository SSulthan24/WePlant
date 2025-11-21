@extends('layouts.dashboard')

@section('title', 'Riwayat Scan | WePlan(t)')
@section('page-title', 'Riwayat Scan')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Riwayat Deteksi Penyakit Daun</h2>
            <p class="text-green-50">Lihat riwayat hasil scan dan deteksi penyakit pada tanaman kelapa sawit</p>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="flex flex-col md:flex-row gap-4">
                <select class="px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option>Semua Status</option>
                    <option>Sehat</option>
                    <option>Terinfeksi</option>
                    <option>Perlu Perhatian</option>
                </select>
                <input type="date" class="px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500">
                <button class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                    Filter
                </button>
            </div>
        </div>

        {{-- Scan Results --}}
        <div class="grid gap-6">
            @php
                $scans = [
                    ['date' => now()->subDays(1), 'status' => 'Sehat', 'confidence' => 98, 'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400'],
                    ['date' => now()->subDays(2), 'status' => 'Terinfeksi', 'confidence' => 85, 'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=400'],
                    ['date' => now()->subDays(3), 'status' => 'Sehat', 'confidence' => 96, 'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400'],
                    ['date' => now()->subDays(5), 'status' => 'Perlu Perhatian', 'confidence' => 72, 'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400'],
                    ['date' => now()->subDays(7), 'status' => 'Sehat', 'confidence' => 94, 'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=400'],
                ];
            @endphp
            @foreach($scans as $index => $scan)
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-48 h-48 rounded-xl overflow-hidden bg-green-100 flex-shrink-0">
                            <img src="{{ $scan['image'] }}" alt="Scan Result" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-green-900 mb-1">Hasil Scan #{{ $loop->iteration }}</h3>
                                    <p class="text-green-600">{{ $scan['date']->format('d M Y, H:i') }}</p>
                                </div>
                                <span class="px-4 py-2 rounded-full text-sm font-semibold 
                                    {{ $scan['status'] === 'Sehat' ? 'bg-green-100 text-green-800' : 
                                       ($scan['status'] === 'Terinfeksi' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $scan['status'] }}
                                </span>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-green-700">Tingkat Keyakinan</span>
                                        <span class="font-semibold text-green-900">{{ $scan['confidence'] }}%</span>
                                    </div>
                                    <div class="w-full bg-green-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $scan['confidence'] }}%"></div>
                                    </div>
                                </div>
                                @if($scan['status'] === 'Terinfeksi')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                        <p class="text-sm text-red-800"><strong>Penyakit Terdeteksi:</strong> Ganoderma boninense</p>
                                        <p class="text-xs text-red-600 mt-1">Disarankan untuk melakukan tindakan pengobatan segera</p>
                                    </div>
                                @endif
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection



