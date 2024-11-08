<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Review;
use App\Exports\ReviewExport;
use Barryvdh\DomPDF\Facade\Pdf;


use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreReviewRequest;
use Maatwebsite\Excel\Excel as ExcelType;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'review-' . now()->format('d-m-Y');

        $start = request('start');
        $end = request('end');
        $reviews = Review::with('user')
            ->when($start, function ($query) use ($start) {
                $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
                return $query->where('created_at', '>=', $formattedStart);
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new ReviewExport($reviews), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.review', [
                'reviews' => $reviews
            ]);
            return $pdf->setPaper('a4', 'landscape')->stream($filename . '.pdf');
        }
    }

    /**
     * Display the report of the resource
     */
    public function report()
    {
        $start = request('start');
        $end = request('end');

        $reviews = Review::with('user')
            ->when($start, function ($query) use ($start) {
                $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
                return $query->where('created_at', '>=', $formattedStart);
            })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->endOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(50)
            ->withQueryString();

        return view('admins.reports.review', [
            'reviews' => $reviews,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serach = request('search');

        $user = request()->user();
        $reviews = Review::with('user')
        ->when($user, function ($query) use ($user) {
            return in_array($user->role, ['admin', 'bidan']) ? $query : $query->where('user_id', $user->id);
        })        
            ->when($serach, function ($query) use ($serach) {
                return $query->where('title', 'like', '%' . $serach . '%');
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('patients.reviews.index', [
            'reviews' => $reviews,
            'search' => $serach,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $user = auth()->user();

    // Pastikan user terautentikasi
    if (!$user) {
        return redirect()->route('login')->with('error', __('Silakan login untuk melanjutkan.'));
    }

    $patient = $user->patient;

    // Pastikan pasien tersedia
    if (!$patient) {
        return redirect()->route('patients.reviews.index')
            ->with('error', __('Silahkan update data diri terlebih dahulu.'));
    }

    // Periksa apakah pasien telah menyelesaikan janji temu
    $hasCompletedAppointment = $patient->appointments()
        ->where('status', 'finished') // Gantilah 'finished' dengan nilai status yang benar
        ->exists();

    if (!$hasCompletedAppointment) {
        return redirect()->route('patients.reviews.index')
            ->with('error', __('Anda tidak dapat menambahkan Kritik Saran dan Testimoni sebelum menyelesaikan janji temu.'));
    }

    return view('patients.reviews.create');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
    // Periksa apakah user memiliki pasien terkait
    $patient = auth()->user()->patient;

    // Jika pasien tidak ditemukan, kembalikan pesan error
    if (!$patient) {
        return redirect()
            ->route('patients.reviews.index')
            ->with('error', __('Anda tidak dapat menambahkan Kritik Saran dan Testimoni tanpa menjadi pasien.'));
    }

    // Periksa apakah pasien memiliki appointment yang sudah selesai atau lengkap
    $hasCompletedAppointment = $patient->appointments()
        ->where('status', 'finished') // Gantilah 'finished' dengan nilai status yang benar
        ->exists();

    if (!$hasCompletedAppointment) {
        return redirect()
            ->route('patients.reviews.index')
            ->with('error', __('Anda tidak dapat menambahkan Kritik Saran dan Testimoni sebelum menyelesaikan janji temu.'));
    }

    // Jika ada appointment yang sudah selesai, lanjutkan untuk membuat review
    $review = Review::create([
        'body' => $request->body,
        'action' => $request->action,
        'user_id' => auth()->user()->id,
    ]);

    return redirect()
        ->route('patients.reviews.index')
        ->with('success', __('Berhasil menambahkan Kritik Saran dan Testimoni ' . $review->title));
    }




    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $user = request()->user();
        if (!in_array($user->role, ['admin', 'bidan']) && $user->id != $review->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat melihat Janji ini'));
        }

        return view('patients.reviews.show', [
            'review' => $review,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        $statuses = ['processing', 'approved', 'rejected'];

        return view('patients.reviews.edit', [
            'review' => $review,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $validated = $request->validated();
        $review->update($validated);

        return redirect()
            ->route('patients.reviews.index')
            ->with('success', __('Berhasil mengupdate Kritik Saran dan Testimoni' . ' ' . $review->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $user = request()->user();
        if (!in_array($user->role, ['admin', 'bidan']) && $user->id != $review->user_id) {
            return redirect()
                ->back()
                ->with('error', __('Anda tidak dapat melihat Janji ini'));
        }

        $review->delete();

        return redirect()
            ->route('patients.reviews.index')
            ->with('success', __('Berhasil menghapus Kritik Saran dan Testimoni' . ' ' . $review->title));
    }
}
