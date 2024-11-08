<?php

namespace App\Http\Controllers;

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
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->selectRaw('appointments.status, sum(appointments.code) + sum(services.price) as sum')
            ->where('users.id', $user->id)
            ->groupBy('appointments.status')
            ->get();

        return view('patients.dashboards.index', [
            'sums' => $sums,
        ]);
    }
}
