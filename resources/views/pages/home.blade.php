@extends('layouts.app')

@section('title', 'Beranda | WePlan(t)')

@section('content')
    <section class="relative min-h-[500px] flex items-center justify-center overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1920" alt="Kelapa Sawit" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 via-green-800/70 to-green-900/80"></div>
        </div>
        
        {{-- Content --}}
        <div class="relative z-10 max-w-6xl mx-auto px-4 md:px-6 py-20 text-center">
            <div class="space-y-6 animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white drop-shadow-lg">
                    Selamat Datang di WePlan(t)
                </h1>
                <p class="text-xl md:text-2xl text-green-50 drop-shadow-md max-w-3xl mx-auto">
                    Sistem berkelanjutan untuk industri kelapa sawit.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white border-y border-green-300">
        <div class="max-w-4xl mx-auto px-4 md:px-6 py-14 text-center space-y-5">
            <h2 class="text-2xl font-semibold text-green-900">WePlan(t) Hadir sebagai Inovator Terbaik demi Kualitas Hidup yang Lebih Baik di Industri Sawit</h2>
            <a href="/tentang" class="inline-flex rounded-full bg-green-600 px-6 py-3 text-white font-semibold hover:bg-green-700 transition">
                Tentang Kami
            </a>
        </div>
    </section>

    <section id="pencapaian" class="bg-green-100 py-16">
        <div class="max-w-6xl mx-auto px-4 md:px-6">
            <h3 class="text-center text-3xl font-bold text-green-900 mb-12">Pencapaian Kami</h3>
            <div class="grid gap-6 md:grid-cols-3">
                @php
                    $metrics = [
                        [
                            'value' => '2.000.000', 
                            'label' => 'Pengiriman', 
                            'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-4.5 4.5H15m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25M15 18.75v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V18.75M15 18.75h-7.5'
                        ],
                        [
                            'value' => '25.000.000', 
                            'label' => 'Tanda Buah Segar (KG)', 
                            'icon' => 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.224 48.224 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.589-1.202L5.25 4.971z'
                        ],
                        [
                            'value' => '10.000', 
                            'label' => 'Mitra', 
                            'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'
                        ],
                    ];
                @endphp
                @foreach ($metrics as $index => $metric)
                    <div class="bg-white p-8 rounded-2xl border border-green-300 text-center space-y-4 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-green-700 text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="{{ $metric['icon'] }}" />
                            </svg>
                        </div>
                        <div class="text-4xl font-bold text-green-900">{{ $metric['value'] }}</div>
                        <p class="text-green-700 font-medium">{{ $metric['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="tentang" class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4 md:px-6 text-center space-y-10">
            <div>
                <h3 class="text-3xl font-semibold text-green-900">Ingin Bergabung?</h3>
                <p class="text-green-700 mt-3 max-w-3xl mx-auto">
                    Pilih peran yang sesuai dengan kebutuhan Anda di sistem WePlan(t).
                </p>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                @php
                    $roles = [
                        [
                            'title' => 'Petani',
                            'description' =>
                                'Akses fitur untuk mengelola kebun, mendeteksi penyakit daun, dan memantau laporan hasil deteksi.',
                            'cta' => 'Daftar Petani',
                        ],
                        [
                            'title' => 'Mitra',
                            'description' =>
                                'Berkolaborasi sebagai mitra untuk membawa solusi agrikultur langsung ke petani.',
                            'cta' => 'Daftar Mitra',
                        ],
                    ];
                @endphp
                @foreach ($roles as $index => $role)
                    <div class="rounded-2xl bg-green-200 border border-green-400 p-10 text-center flex flex-col gap-4 items-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        <h4 class="text-2xl font-semibold text-green-900">{{ $role['title'] }}</h4>
                        <p class="text-green-700">{{ $role['description'] }}</p>
                        <a href="{{ $role['title'] === 'Petani' ? route('register.farmer') : route('register.partner') }}" class="inline-flex rounded-full bg-green-100 px-5 py-3 font-semibold text-green-900 hover:bg-green-50 transition transform hover:scale-105">
                            {{ $role['cta'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-green-100 py-16">
        <div class="max-w-6xl mx-auto px-4 md:px-6 space-y-8">
            <h3 class="text-center text-2xl font-semibold text-green-900">Kolaborasi Lapangan</h3>
            <div class="grid gap-6 md:grid-cols-3">
                @php
                    $images = [
                        'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600',
                        'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=600',
                        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=600',
                    ];
                @endphp
                @foreach ($images as $index => $image)
                    <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        <img src="{{ $image }}" alt="Kolaborasi" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('styles')
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fade-in-right {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
        
        .animate-fade-in-right {
            animation: fade-in-right 0.8s ease-out;
        }
    </style>
    @endpush
@endsection


