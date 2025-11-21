@extends('layouts.app')

@section('title', 'Tentang | WePlan(t)')

@section('content')
    <section class="bg-green-100">
        <div class="max-w-4xl mx-auto px-4 md:px-6 py-20 text-center space-y-6">
            <h1 class="text-4xl font-semibold text-green-900">Tentang WePlan(t)</h1>
            <p class="text-lg text-green-700">
                Kami menghadirkan sistem untuk membantu pengelolaan kebun sawit yang lebih efisien, produktif, dan berkelanjutan.
            </p>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="max-w-5xl mx-auto px-4 md:px-6">
            <div class="rounded-3xl border border-green-300 bg-green-100 px-6 py-12 text-center space-y-8">
                <div>
                    <h2 class="text-3xl font-semibold text-green-900">TIM KAMI</h2>
                    <p class="mt-4 text-green-700">
                        Kami adalah tim kecil yang berdedikasi dalam mengembangkan sistem di industri kelapa sawit.</br>
                        Dengan latar belakang berbeda, kami berkomitmen untuk menghadirkan sistem yang bermanfaat bagi petani </br>
                        untuk mengelola kebun dan para pebisnis untuk mengelola usaha pertaniannya.
                    </p>
                </div>
                <div class="flex flex-col items-center gap-12">
                    @php
                        $leader = [
                            'name' => 'Naufa Hilmatuzzahra', 
                            'role' => 'Ketua Tim',
                            'image' => 'images/profile/Naufa.jpg'
                        ];
                        $members = [
                            [
                                'name' => 'Hafiz Tiftazani', 
                                'role' => 'Anggota',
                                'image' => 'images/profile/Hafiz.jpg'
                            ],
                            [
                                'name' => 'Althof Zufar M', 
                                'role' => 'Anggota',
                                'image' => 'images/profile/Althof.jpg'
                            ],
                        ];
                    @endphp
                    {{-- Ketua Tim di atas --}}
                    <div class="flex flex-col items-center">
                        <div class="relative pb-12">
                            {{-- Gambar profil lingkaran --}}
                            <img src="{{ asset($leader['image']) }}" alt="{{ $leader['name'] }}" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-white shadow-lg">
                            {{-- Label nama yang menyatu setengah dengan lingkaran (overlap) --}}
                            <div class="absolute top-20 left-1/2 transform -translate-x-1/2 bg-white px-4 py-2 shadow-md min-w-[200px] text-center border border-gray-200">
                                <p class="font-semibold text-gray-900">{{ $leader['name'] }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $leader['role'] }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Anggota di bawah --}}
                    <div class="flex flex-col md:flex-row gap-20 md:gap-32 items-start">
                        @foreach ($members as $member)
                            <div class="flex flex-col items-center">
                                <div class="relative pb-12">
                                    {{-- Gambar profil lingkaran --}}
                                    <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-white shadow-lg">
                                    {{-- Label nama yang menyatu setengah dengan lingkaran (overlap) --}}
                                    <div class="absolute top-20 left-1/2 transform -translate-x-1/2 bg-white px-4 py-2 shadow-md min-w-[200px] text-center border border-gray-200">
                                        <p class="font-semibold text-gray-900">{{ $member['name'] }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $member['role'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


