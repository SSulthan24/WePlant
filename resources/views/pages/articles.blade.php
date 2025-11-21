@extends('layouts.app')

@section('title', 'Artikel | WePlan(t)')

@section('content')
    <section class="bg-green-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 text-center space-y-4 sm:space-y-6">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-green-900">Artikel WePlan(t)</h1>
            <p class="text-base sm:text-lg lg:text-xl text-green-700 px-4">
                Jelajahi artikel pilihan yang memperkaya pengetahuan Anda seputar dunia kelapa sawit dan teknologi agrikultur.
            </p>
        </div>
    </section>

    <section class="bg-white py-8 md:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @forelse($articles as $index => $article)
                    <article class="rounded-2xl border border-green-300 p-4 sm:p-5 lg:p-6 flex flex-col gap-3 sm:gap-4 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="aspect-[4/3] rounded-xl bg-green-100 overflow-hidden">
                            @if($article->image)
                                <img src="{{ $article->image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&h=450&fit=crop" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        @if($article->tag)
                            <span class="text-xs sm:text-sm font-semibold uppercase tracking-wide text-green-600">{{ $article->tag }}</span>
                        @endif
                        <h3 class="text-base sm:text-lg font-semibold text-green-900 line-clamp-2 min-h-[3rem]">{{ $article->title }}</h3>
                        <a href="{{ route('articles.show', $article->id) }}" class="text-sm sm:text-base font-semibold text-green-700 hover:text-green-900 hover:underline transition mt-auto">
                            Baca selengkapnya →
                        </a>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-green-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <p class="text-green-600 text-lg mb-4">Belum ada artikel yang dipublikasikan</p>
                    </div>
                @endforelse
            </div>
            
            @if($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
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
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @endpush
@endsection



