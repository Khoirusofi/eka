<?php

namespace App\Exports;

use App\Models\Article;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArticleExport  implements FromArray, WithHeadings
{
    protected Collection $articles;

    public function __construct(Collection $articles)
    {
        $this->articles = $articles;
    }

    /**
     * array of data to export
     *
     * @return array
     */
    public function array(): array
    {
        return $this->articles->map(function (Article $article) {
            return [
                $article->id,
                $article->created_at,
                $article->title,
                $article->body,
                $article->status,
                $article->views,
                $article->excerpt,
                $article->photo,
            ];
        })->toArray();
    }


    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'no',
            'created_at',
            'title',
            'body',
            'status',
            'views',
            'excerpt',
            'photo',
        ];
    }
}
