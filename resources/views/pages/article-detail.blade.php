@extends('layouts.app')

@section('title', $article->title . ' | WePlan(t)')

@section('content')
    <section class="bg-green-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <a href="{{ route('articles') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-900 transition mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Artikel
            </a>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                @if($article->image)
                    <div class="aspect-video w-full overflow-hidden">
                        <img src="{{ $article->image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    </div>
                @endif
                
                <div class="p-6 sm:p-8 lg:p-12">
                    @if($article->tag)
                        <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">
                            {{ $article->tag }}
                        </span>
                    @endif
                    
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-green-900 mb-4">
                        {{ $article->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-green-600 mb-6 pb-6 border-b border-green-200">
                        <span>{{ $article->created_at->format('d M Y') }}</span>
                        <span>•</span>
                        <span>{{ $article->views }} views</span>
                        @if($article->user)
                            <span>•</span>
                            <span>Oleh {{ $article->user->name }}</span>
                        @endif
                    </div>
                    
                    <div class="prose prose-green max-w-none">
                        <div class="text-green-800 leading-relaxed whitespace-pre-line">
                            {!! nl2br(e($article->content)) !!}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 text-center">
                <a href="{{ route('articles') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Artikel
                </a>
            </div>
        </div>
    </section>
    
    @push('styles')
    <style>
        .prose {
            color: #1f2937;
        }
        .prose p {
            margin-bottom: 1.25em;
        }
        .prose h2 {
            font-size: 1.5em;
            font-weight: 700;
            margin-top: 2em;
            margin-bottom: 1em;
            color: #065f46;
        }
        .prose h3 {
            font-size: 1.25em;
            font-weight: 600;
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            color: #047857;
        }
        .prose ul, .prose ol {
            margin-bottom: 1.25em;
            padding-left: 1.625em;
        }
        .prose li {
            margin-bottom: 0.5em;
        }
        .prose strong {
            font-weight: 600;
            color: #065f46;
        }
    </style>
    @endpush
@endsection


