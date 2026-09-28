<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $dailyReport = $this->getDailyReport();
        return view('admin.reports.index', compact('dailyReport'));
    }

    public function daily()
    {
        $report = Booking::where('status', 'confirmed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(amount) as total_revenue'),
                DB::raw('AVG(amount) as avg_fare')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('admin.reports.daily', compact('report'));
    }

    public function monthly()
    {
        $report = Booking::where('status', 'confirmed')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(amount) as total_revenue'),
                DB::raw('AVG(amount) as avg_fare')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports.monthly', compact('report'));
    }

    private function getDailyReport()
    {
        return Booking::where('status', 'confirmed')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
