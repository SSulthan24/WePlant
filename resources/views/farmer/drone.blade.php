@extends('layouts.dashboard')

@section('title', 'Drone Feed | WePlan(t)')
@section('page-title', 'Drone Feed')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <h2 class="text-2xl font-bold mb-2">Live Drone Feed</h2>
            <p class="text-green-50">Pantau kondisi kebun Anda secara real-time melalui drone</p>
        </div>

        {{-- Live Feed --}}
        <div class="bg-green-200 rounded-2xl p-8 animate-fade-in">
            <div class="aspect-video rounded-xl overflow-hidden bg-green-300 shadow-lg relative">
                {{-- Video Element --}}
                <video id="liveFeed" autoplay playsinline class="w-full h-full object-cover hidden"></video>
                
                {{-- Placeholder when camera is off --}}
                <div id="cameraPlaceholder" class="w-full h-full flex items-center justify-center bg-green-300">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-green-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <p class="text-green-700 font-semibold text-xl mb-2">Kamera Belum Aktif</p>
                        <button id="startCameraBtn" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                            Aktifkan Kamera
                        </button>
                    </div>
                </div>
                
                {{-- Overlay Controls --}}
                <div id="cameraOverlay" class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent hidden">
                    <div class="absolute bottom-4 left-4 right-4">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <p class="font-semibold text-lg">Live Feed - Kebun Utama</p>
                                <p class="text-sm text-green-100">Kamera: Webcam</p>
                            </div>
                            <div class="flex items-center gap-2 bg-green-600/80 px-3 py-2 rounded-lg">
                                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                <span class="text-sm font-semibold">LIVE</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Control Buttons --}}
                    <div class="absolute top-4 right-4 flex gap-2">
                        <button id="captureBtn" class="bg-white/20 backdrop-blur-sm text-white p-2 rounded-lg hover:bg-white/30 transition" title="Capture">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <button id="stopCameraBtn" class="bg-white/20 backdrop-blur-sm text-white p-2 rounded-lg hover:bg-white/30 transition" title="Stop Camera">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Camera Info --}}
            <div id="cameraInfo" class="mt-4 grid grid-cols-3 gap-4 hidden">
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-sm text-green-600 mb-1">Status</p>
                    <p class="text-xl font-bold text-green-900" id="cameraStatus">Aktif</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-sm text-green-600 mb-1">Resolusi</p>
                    <p class="text-xl font-bold text-green-900" id="cameraResolution">-</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-sm text-green-600 mb-1">FPS</p>
                    <p class="text-xl font-bold text-green-900">30</p>
                </div>
            </div>
        </div>

        {{-- Recent Captures --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-green-900">Kaptur Terbaru</h3>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
                    Lihat Semua
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $captures = [
                        ['title' => 'Area Utara', 'date' => now()->subHours(2), 'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400'],
                        ['title' => 'Area Selatan', 'date' => now()->subDays(1), 'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=400'],
                        ['title' => 'Area Timur', 'date' => now()->subDays(2), 'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400'],
                        ['title' => 'Area Barat', 'date' => now()->subDays(3), 'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400'],
                        ['title' => 'Area Tengah', 'date' => now()->subDays(4), 'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=400'],
                        ['title' => 'Area Perbatasan', 'date' => now()->subDays(5), 'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400'],
                    ];
                @endphp
                @foreach($captures as $index => $capture)
                    <div class="bg-white rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 animate-fade-in group" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="aspect-square bg-green-300 relative overflow-hidden">
                            <img src="{{ $capture['image'] }}" alt="Drone Capture" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full font-semibold">
                                {{ $capture['date']->diffForHumans() }}
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="font-semibold text-green-900">{{ $capture['title'] }}</p>
                            <p class="text-sm text-green-600 mt-1">{{ $capture['date']->format('d M Y, H:i') }}</p>
                            <button class="mt-2 text-sm text-green-600 hover:text-green-700 font-medium">
                                Lihat Detail →
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let stream = null;
        const video = document.getElementById('liveFeed');
        const placeholder = document.getElementById('cameraPlaceholder');
        const overlay = document.getElementById('cameraOverlay');
        const cameraInfo = document.getElementById('cameraInfo');
        const startBtn = document.getElementById('startCameraBtn');
        const stopBtn = document.getElementById('stopCameraBtn');
        const captureBtn = document.getElementById('captureBtn');
        const cameraStatus = document.getElementById('cameraStatus');
        const cameraResolution = document.getElementById('cameraResolution');

        // Start Camera
        startBtn.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment', // Use back camera if available, otherwise front
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    } 
                });
                
                video.srcObject = stream;
                video.play();
                
                // Show video and hide placeholder
                video.classList.remove('hidden');
                placeholder.classList.add('hidden');
                overlay.classList.remove('hidden');
                cameraInfo.classList.remove('hidden');
                
                // Update resolution
                const track = stream.getVideoTracks()[0];
                const settings = track.getSettings();
                cameraResolution.textContent = `${settings.width}x${settings.height}`;
                cameraStatus.textContent = 'Aktif';
                
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            }
        });

        // Stop Camera
        stopBtn.addEventListener('click', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
                
                video.classList.add('hidden');
                placeholder.classList.remove('hidden');
                overlay.classList.add('hidden');
                cameraInfo.classList.add('hidden');
                
                cameraStatus.textContent = 'Nonaktif';
            }
        });

        // Capture Screenshot
        captureBtn.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);
            
            // Convert to blob and download
            canvas.toBlob((blob) => {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `drone-capture-${Date.now()}.jpg`;
                a.click();
                URL.revokeObjectURL(url);
            }, 'image/jpeg', 0.9);
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
    @endpush
@endsection

