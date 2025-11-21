@extends('layouts.dashboard')

@section('title', 'Kelola Artikel | WePlan(t)')
@section('page-title', 'Kelola Artikel')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white animate-fade-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Kelola Artikel</h2>
                    <p class="text-green-50">Kelola artikel dan konten edukasi untuk petani</p>
                </div>
                <a href="{{ route('admin.articles.create') }}" class="px-6 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-green-50 transition whitespace-nowrap">
                    + Buat Artikel
                </a>
            </div>
        </div>

        {{-- Articles List --}}
        <div class="grid gap-6">
            @forelse($articles as $index => $article)
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex flex-col lg:flex-row items-start justify-between gap-4">
                        <div class="flex-1 w-full">
                            <h3 class="text-xl font-bold text-green-900 mb-2">{{ $article->title }}</h3>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-green-600 mb-4">
                                <span>{{ $article->created_at->format('d M Y') }}</span>
                                <span>•</span>
                                <span>{{ $article->views }} views</span>
                                @if($article->tag)
                                    <span>•</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">{{ $article->tag }}</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
                                    Edit
                                </a>
                                <a href="{{ route('articles') }}" target="_blank" class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition text-sm font-semibold">
                                    Preview
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap
                            {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $article->status === 'published' ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-green-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <p class="text-green-600 text-lg mb-4">Belum ada artikel</p>
                    <a href="{{ route('admin.articles.create') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Buat Artikel Pertama
                    </a>
                </div>
            @endforelse
        </div>

        @if($articles->hasPages())
            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
@endsection
