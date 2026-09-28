<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with('trips')->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'base_price' => 'required|numeric|min:0',
        ]);

        Route::create($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Tuyến đường đã được tạo');
    }

    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'from_city' => 'required|string',
            'to_city' => 'required|string',
            'base_price' => 'required|numeric|min:0',
        ]);

        $route->update($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Tuyến đường đã được cập nhật');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return back()->with('success', 'Tuyến đường đã bị xóa');
    }
}
