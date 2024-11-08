<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller {
    public function toggleLike($articleId) {
        $like = Like::where('user_id', Auth::id())
                    ->where('article_id', $articleId)
                    ->first();

        if ($like) {
            $like->delete();
            return back()->with('success', 'Like telah dihapus.');
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'article_id' => $articleId,
            ]);

            return back()->with('success', 'Like berhasil ditambahkan.');
        }
    }
}
