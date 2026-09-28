<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $trips = Trip::with('route')
            ->where('departure_date', '>=', now()->toDateString())
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->limit(8)
            ->get();

        return view('home', compact('trips'));
    }

    public function search(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $date = $request->travel_date;

        $trips = Trip::with('route')
            ->whereHas('route', function ($q) use ($from, $to) {
                $q->where('from_city', 'LIKE', "%$from%")
                  ->where('to_city', 'LIKE', "%$to%");
            })
            ->whereDate('departure_date', $date)
            ->orderBy('departure_time')
            ->get();

        return view('home', [
            'trips' => $trips,
            'from' => $from,
            'to' => $to,
            'date' => $date,
            'searched' => true,
        ]);
    }
}
