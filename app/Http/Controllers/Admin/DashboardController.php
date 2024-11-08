<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();

        $sums = DB::table('appointments')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->selectRaw('appointments.status, sum(appointments.code) + sum(services.price) as sum')
            ->groupBy('appointments.status')
            ->get();

        return view('admins.dashboards.index', [
            'sums' => $sums,
        ]);
    }
}