<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\UserExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Maatwebsite\Excel\Excel as ExcelType;

class UserController extends Controller
{
    /**
     * Export data to CSV
     */
    public function export()
    {
        $type = request('format');
        $filename = 'user-' . now()->format('d-m-Y');

        $start = request('start');
        $end = request('end');
        $users = User::when($start, function ($query) use ($start) {
            $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
            return $query->where('created_at', '>=', $formattedStart);
        })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->startOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        if ($type == 'csv') {
            return Excel::download(new UserExport($users), $filename . '.csv', ExcelType::CSV);
        } else {
            $pdf = Pdf::loadView('reports.user', [
                'users' => $users
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
        $users = User::when($start, function ($query) use ($start) {
            $formattedStart = Carbon::createFromFormat('d-m-Y', $start)->startOfDay();
            return $query->where('created_at', '>=', $formattedStart);
        })
            ->when($end, function ($query) use ($end) {
                $formattedEnd = Carbon::createFromFormat('d-m-Y', $end)->startOfDay();
                return $query->where('created_at', '<=', $formattedEnd);
            })
            ->orderBy('created_at', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('admins.reports.user', [
            'users' => $users,
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

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->paginate(10)
            ->withQueryString();

        return view('admins.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = [
            'admin' => __('Administrator'),
            'patient' => __('Pasien'),
            'bidan' => __('Bidan'),
        ];

        return view('admins.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return redirect()
            ->route('admins.users.index')
            ->with('success', __('Berhasil menambahkan pengguna' . ' ' . $user->name));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // disabled
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = [
            'admin' => __('Administrator'),
            'patient' => __('Pasien'),
            'bidan' => __('Bidan'),
        ];

        return view('admins.users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user->update($validated);

        return redirect()
            ->route('admins.users.index')
            ->with('success', __('Berhasil mengupdate pengguna' . ' ' . $user->name));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admins.users.index')
            ->with('success', __('Berhasil menghapus pengguna' . ' ' . $user->name));
    }
}
