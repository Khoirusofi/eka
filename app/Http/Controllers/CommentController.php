<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Fungsi untuk menyimpan komentar
    public function store(Request $request, $articleId)
{
    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    try {
        Comment::create([
            'article_id' => $articleId,
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menambahkan komentar. Silakan coba lagi.');
    }
}


    // Fungsi untuk menghapus komentar
    public function destroy(Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang bisa menghapusnya
        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
