<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todayRevenue = Booking::where('status', 'confirmed')
            ->whereDate('created_at', today())
            ->sum('amount');

        $totalBookings = Booking::where('status', 'confirmed')->count();
        $totalTrips = Trip::count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('amount');

        $recentBookings = Booking::with(['trip.route', 'user'])
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $chartData = Booking::where('status', 'confirmed')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', [
            'todayRevenue' => $todayRevenue,
            'totalBookings' => $totalBookings,
            'totalTrips' => $totalTrips,
            'totalRevenue' => $totalRevenue,
            'recentBookings' => $recentBookings,
            'chartData' => $chartData,
        ]);
    }
}
