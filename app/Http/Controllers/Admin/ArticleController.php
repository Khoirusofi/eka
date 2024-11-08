<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Exports\ArticleExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelType;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    protected array $statuses = ['published', 'draft'];

    /**
     * Export data to CSV or PDF.
     */
    public function export()
    {
        $type = request('format');
        $filename = 'article-' . now()->format('d-m-Y');

        $start = request('start');
        $end = request('end');
        $articles = Article::when($start, function ($query) use ($start) {
            $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
            return $query->where('created_at', '>=', $formattedStart);
        })
        ->when($end, function ($query) use ($end) {
            $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
            return $query->where('created_at', '<=', $formattedEnd);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        if ($type === 'csv') {
            return Excel::download(new ArticleExport($articles), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.article', [
                'articles' => $articles
            ]);
            return $pdf->setPaper('a4', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource.
     */
    public function report()
    {
        $start = request('start');
        $end = request('end');

        $articles = Article::when($start, function ($query) use ($start) {
            $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
            return $query->where('created_at', '>=', $formattedStart);
        })
        ->when($end, function ($query) use ($end) {
            $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
            return $query->where('created_at', '<=', $formattedEnd);
        })
        ->orderBy('created_at', 'asc')
        ->paginate(20)
        ->withQueryString();

        return view('admins.reports.article', [
            'articles' => $articles,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $status = request('status');
        $statuses = $this->statuses;

        $articles = Article::when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })->paginate(10)->withQueryString();

        return view('admins.articles.index', [
            'articles' => $articles,
            'statuses' => $statuses,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $statuses = $this->statuses;
    $categories = Category::all(); // Fetch categories

    return view('admins.articles.create', [
        'statuses' => $statuses,
        'categories' => $categories, // Pass categories to the view
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
{
    $validated = $request->validated();

    // Create slug from title
    $validated['slug'] = Str::slug($validated['title']);

    // Save new article to database
    $article = Article::create($validated);

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('media/articles', $filename);
        $article->photo = $filename;
        $article->save();
    }

    return redirect()
        ->route('admins.articles.index')
        ->with('success', __('Berhasil menambahkan artikel: :title', ['title' => $article->title]));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
{
    // Find the article by slug or throw a 404 error if not found
    $article = Article::where('slug', $slug)->firstOrFail();
    
    // Get the statuses. This assumes you have a property or method for statuses.
    $statuses = $this->statuses;

    // Fetch categories. Adjust the query if necessary based on your Category model.
    $categories = Category::all();

    // Return the edit view with article data, statuses, and categories
    return view('admins.articles.edit', [
        'article' => $article,
        'statuses' => $statuses,
        'categories' => $categories, // Pass categories to the view
    ]);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, $slug)
{
    $article = Article::where('slug', $slug)->firstOrFail();
    $validated = $request->validated();

    // Update slug only if title changes
    if ($validated['title'] !== $article->title) {
        $validated['slug'] = Str::slug($validated['title']);
    }

    // Update article details
    $article->update($validated);

    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($article->photo && Storage::exists('media/articles/' . $article->photo)) {
            Storage::delete('media/articles/' . $article->photo);
        }

        // Store new photo with a unique name
        $file = $request->file('photo');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
        $file->storeAs('media/articles', $filename); // Store file with the unique name
        $article->photo = $filename; // Store only the unique file name in the database
        $article->save();
    }

    return redirect()
        ->route('admins.articles.index')
        ->with('success', __('Berhasil mengupdate artikel: :title', ['title' => $article->title]));
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // Delete photo if exists
        if ($article->photo && Storage::exists($article->photo)) {
            Storage::delete($article->photo);
        }

        $article->delete();

        return redirect()
            ->route('admins.articles.index')
            ->with('success', __('Berhasil menghapus artikel: :title', ['title' => $article->title]));
    }
}
