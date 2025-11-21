@extends('layouts.dashboard')

@section('title', 'Dashboard Petani | WePlan(t)')
@section('page-title', 'Welcome')

@section('content')
    {{-- Farm Image --}}
    <div class="bg-green-200 rounded-2xl p-12 mb-6">
        <div class="aspect-video flex items-center justify-center text-green-600 font-semibold text-xl">
            GAMBAR KEBUN
        </div>
    </div>

    {{-- Preview Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-green-200 rounded-2xl p-6">
            <h3 class="text-lg font-bold text-green-900 mb-4">Preview Drone Feed</h3>
            <div class="aspect-square rounded-xl overflow-hidden bg-green-300 shadow-lg relative">
                {{-- Video Element --}}
                <video id="dashboardLiveFeed" autoplay playsinline class="w-full h-full object-cover hidden"></video>
                
                {{-- Placeholder when camera is off --}}
                <div id="dashboardCameraPlaceholder" class="w-full h-full flex items-center justify-center bg-green-300">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <p class="text-green-700 font-semibold mb-2">Kamera Belum Aktif</p>
                        <button id="dashboardStartCameraBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm">
                            Aktifkan
                        </button>
                    </div>
                </div>
                
                {{-- Overlay Controls --}}
                <div id="dashboardCameraOverlay" class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent hidden">
                    <div class="absolute bottom-2 left-2 right-2">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <p class="font-semibold text-sm">Live Feed</p>
                            </div>
                            <div class="flex items-center gap-1 bg-green-600/80 px-2 py-1 rounded text-xs">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                                <span class="font-semibold">LIVE</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <button id="dashboardStopCameraBtn" class="bg-white/20 backdrop-blur-sm text-white p-1.5 rounded hover:bg-white/30 transition" title="Stop">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-green-200 rounded-2xl p-12">
            <div class="aspect-square flex items-center justify-center text-green-600 font-semibold">
                Preview riwayat scan
            </div>
        </div>
    </div>

    {{-- Farm Map --}}
    <div class="bg-green-200 rounded-2xl p-12">
        <div class="aspect-video flex items-center justify-center text-green-600 font-semibold text-xl">
            Peta Kebun
        </div>
    </div>

    @push('scripts')
    <script>
        let dashboardStream = null;
        const dashboardVideo = document.getElementById('dashboardLiveFeed');
        const dashboardPlaceholder = document.getElementById('dashboardCameraPlaceholder');
        const dashboardOverlay = document.getElementById('dashboardCameraOverlay');
        const dashboardStartBtn = document.getElementById('dashboardStartCameraBtn');
        const dashboardStopBtn = document.getElementById('dashboardStopCameraBtn');

        // Start Camera
        dashboardStartBtn.addEventListener('click', async () => {
            try {
                dashboardStream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    } 
                });
                
                dashboardVideo.srcObject = dashboardStream;
                dashboardVideo.play();
                
                // Show video and hide placeholder
                dashboardVideo.classList.remove('hidden');
                dashboardPlaceholder.classList.add('hidden');
                dashboardOverlay.classList.remove('hidden');
                
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            }
        });

        // Stop Camera
        dashboardStopBtn.addEventListener('click', () => {
            if (dashboardStream) {
                dashboardStream.getTracks().forEach(track => track.stop());
                dashboardStream = null;
                
                dashboardVideo.classList.add('hidden');
                dashboardPlaceholder.classList.remove('hidden');
                dashboardOverlay.classList.add('hidden');
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (dashboardStream) {
                dashboardStream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
    @endpush
@endsection

