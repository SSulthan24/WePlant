<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'WePlan(t)')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-green-50 text-green-900 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-green-200 sticky top-0 z-10">
            <div class="max-w-6xl mx-auto px-4 md:px-6 py-4 flex items-center justify-between relative">
                <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-tight">
                    WePlan(t)
                </a>
                @php
                    $navLinks = [
                        ['label' => 'Beranda', 'route' => 'home'],
                        ['label' => 'Tentang', 'route' => 'about'],
                        ['label' => 'Toko', 'route' => 'shop'],
                        ['label' => 'Artikel', 'route' => 'articles'],
                    ];
                @endphp
                <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-green-600 absolute left-1/2 transform -translate-x-1/2">
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="{{ request()->routeIs($link['route']) ? 'text-green-900 border-b-2 border-green-700 pb-1' : 'hover:text-green-900 transition-colors' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('cart') }}"
                        class="hidden sm:inline-flex items-center justify-center rounded-full border border-green-200 w-10 h-10 font-semibold text-green-700 hover:bg-green-100 transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437m0 0L6.75 14.25h10.5l1.644-7.978a1.125 1.125 0 0 0-1.102-1.347H5.106m0 0L4.5 3.75M6.75 18.75a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm9 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        @php
                            $cartCount = count(session('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-green-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-bounce">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex rounded-full border border-green-400 px-4 py-2 font-semibold hover:bg-green-100 transition">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex rounded-full border border-green-400 px-4 py-2 font-semibold hover:bg-green-100 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register.farmer') }}"
                            class="inline-flex rounded-full bg-green-600 px-4 py-2 font-semibold text-white hover:bg-green-700 transition">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="flex-1">
            @if(session('success'))
                <div class="max-w-6xl mx-auto px-4 md:px-6 pt-4">
                    <div class="bg-green-200 border border-green-500 text-green-900 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('info'))
                <div class="max-w-6xl mx-auto px-4 md:px-6 pt-4">
                    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg">
                        {{ session('info') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="max-w-6xl mx-auto px-4 md:px-6 pt-4">
                    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if($errors->any())
                <div class="max-w-6xl mx-auto px-4 md:px-6 pt-4">
                    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>

        <footer class="mt-16 bg-green-600 text-white">
            <div class="max-w-6xl mx-auto px-4 md:px-6 py-12 flex flex-col gap-10 md:flex-row md:justify-between">
                <div>
                    <p class="text-2xl font-semibold">WEPLAN(T)</p>
                    <p class="mt-3 text-sm text-green-100 max-w-sm">
                        Sistem berkelanjutan untuk meningkatkan kualitas hidup petani kelapa sawit melalui kolaborasi
                        digital dengan mitra terbaik.
                    </p>
                </div>
                <div class="flex flex-col gap-2 text-sm">
                    <p class="font-semibold">Sitemap:</p>
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}" class="text-green-100 hover:text-white">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
                <div class="text-sm">
                    <p class="font-semibold mb-3">Ikuti Kami di:</p>
                    <div class="flex gap-4 items-center">
                        {{-- YouTube Logo --}}
                        <a href="#" target="_blank" class="text-white hover:text-green-200 transition" aria-label="YouTube">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        {{-- LinkedIn Logo --}}
                        <a href="#" target="_blank" class="text-white hover:text-green-200 transition" aria-label="LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        {{-- Instagram Logo --}}
                        <a href="#" target="_blank" class="text-white hover:text-green-200 transition" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-green-700 text-center py-4 text-xs text-green-200">
                © {{ date('Y') }} WePlan(t). All rights reserved.
            </div>
        </footer>
    </div>
    @stack('scripts')
    
    <style>
        .modal-overlay {
            opacity: 0;
            transition: opacity 0.2s ease-out;
        }
        
        .modal-panel {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.2s ease-out, transform 0.2s ease-out;
        }
        
        .modal-panel.scale-100 {
            transform: scale(1);
        }
    </style>
    
    <script>
        // SweetAlert2 untuk konfirmasi delete
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const form = this;
                    const formData = new FormData(form);
                    const action = form.getAttribute('action');
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Tindakan ini tidak dapat dibatalkan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'px-6 py-2 rounded-lg font-semibold',
                            cancelButton: 'px-6 py-2 rounded-lg font-semibold'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const tempForm = document.createElement('form');
                            tempForm.method = 'POST';
                            tempForm.action = action;
                            
                            formData.forEach((value, key) => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = value;
                                tempForm.appendChild(input);
                            });
                            
                            document.body.appendChild(tempForm);
                            tempForm.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>

