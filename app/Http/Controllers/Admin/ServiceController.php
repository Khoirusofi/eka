<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Service;
use App\Exports\ServiceExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelType;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'service-' . now()->format('d-m-Y');

        $start = request('start');
        $end = request('end');
        $services = Service::when($start, function ($query) use ($start) {
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
            return Excel::download(new ServiceExport($services), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.service', [
                'services' => $services
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

        $services = Service::when($start, function ($query) use ($start) {
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

        return view('admins.reports.service', [
            'services' => $services,
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

        $services = Service::when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admins.services.index', [
            'services' => $services,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $validated = $request->validated();

        $service = Service::create($validated);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
            $file->storeAs('media/services', $filename); // Store file with the unique name
            $service->photo = $filename; // Store only the unique file name in the database
            $service->save();
        }

        return redirect()
            ->route('admins.services.index')
            ->with('success', __('Berhasil menambahkan service' . ' ' . $service->title));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // disabled
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admins.services.edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validated = $request->validated();
        $service->update($validated);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($service->photo && Storage::exists('media/services/' . $service->photo)) {
                Storage::delete('media/services/' . $service->photo);
            }

            // Store new photo with a unique name
            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
            $file->storeAs('media/services', $filename); // Store file with the unique name
            $service->photo = $filename; // Store only the unique file name in the database
            $service->save();
        }

        return redirect()
            ->route('admins.services.index')
            ->with('success', __('Berhasil mengupdate service' . ' ' . $service->title));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admins.services.index')
            ->with('success', __('Berhasil menghapus service' . ' ' . $service->title));
    }
}
