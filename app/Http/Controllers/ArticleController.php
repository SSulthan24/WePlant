<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        
        return view('pages.articles', compact('articles'));
    }
    
    public function show($id)
    {
        $article = Article::where('status', 'published')->findOrFail($id);
        
        // Increment views
        $article->increment('views');
        
        return view('pages.article-detail', compact('article'));
    }
}
