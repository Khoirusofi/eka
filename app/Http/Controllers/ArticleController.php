<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display the specified article.
     */
    public function show($slug)
    {
        // Temukan artikel berdasarkan slug
        $article = Article::where('slug', $slug)->firstOrFail();

        // Hitung jumlah likes untuk artikel
        $likesCount = $article->likes()->count();

        // Ambil 3 artikel terkait (dapat disesuaikan jika ada kriteria tertentu)
        $relatedArticles = Article::where('status', 'published')
            ->where('id', '!=', $article->id) // Menghindari artikel yang sama
            ->take(3)
            ->get();

        // Update jumlah tampilan artikel
        $article->increment('views');

        // Kirim data ke view
        return view('articles.show', [
            'article' => $article,
            'likesCount' => $likesCount,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
