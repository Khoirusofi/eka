<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    public function index()
    {
        $articles = Article::where('status', 'published')
        ->inRandomOrder()
        ->limit(6)
        ->get();

        return view('welcome', compact('articles'));

}
    

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (!empty($article->title)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if (!empty($article->title)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }
}
