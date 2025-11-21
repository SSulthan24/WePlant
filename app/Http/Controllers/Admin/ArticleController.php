<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.articles', compact('articles'));
    }
    
    public function create()
    {
        return view('admin.article-create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tag' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }
        
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'tag' => $request->tag,
            'status' => $request->status,
            'image' => $imageUrl,
            'user_id' => auth()->id(),
            'views' => 0,
        ]);
        
        return redirect()->route('admin.articles')->with('success', 'Artikel berhasil dibuat');
    }
    
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.article-edit', compact('article'));
    }
    
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tag' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $article->title = $request->title;
        $article->content = $request->content;
        $article->tag = $request->tag;
        $article->status = $request->status;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = asset('storage/' . $imagePath);
        }
        
        $article->save();
        
        return redirect()->route('admin.articles')->with('success', 'Artikel berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        
        return back()->with('success', 'Artikel berhasil dihapus');
    }
}
