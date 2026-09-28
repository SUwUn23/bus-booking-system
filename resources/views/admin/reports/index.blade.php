@extends('layouts.admin')

@section('title', 'Báo cáo doanh thu')

@section('content')
<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-slate-600 mb-2">Doanh thu tuần này</p>
        <p class="text-3xl font-black text-red-500">
            {{ number_format($dailyReport->sum(fn($r) => $r->revenue), 0, ',', '.') }}₫
        </p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-slate-600 mb-2">Số đặt vé tuần này</p>
        <p class="text-3xl font-black text-blue-500">{{ $dailyReport->sum(fn($r) => $r->total_bookings) }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-slate-600 mb-2">Giá vé trung bình</p>
        <p class="text-3xl font-black text-green-500">
            {{ number_format($dailyReport->avg(fn($r) => $r->avg_fare), 0, ',', '.') }}₫
        </p>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="text-lg font-bold">Báo cáo theo ngày</h2>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b">
                <th class="px-6 py-3 text-left font-semibold">Ngày</th>
                <th class="px-6 py-3 text-left font-semibold">Số đặt vé</th>
                <th class="px-6 py-3 text-left font-semibold">Doanh thu</th>
                <th class="px-6 py-3 text-left font-semibold">Giá trung bình</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyReport as $report)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-6 py-3 font-semibold">{{ \Carbon\Carbon::parse($report->date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-3">{{ $report->total_bookings }} vé</td>
                    <td class="px-6 py-3 font-semibold text-red-500">{{ number_format($report->revenue, 0, ',', '.') }}₫</td>
                    <td class="px-6 py-3">{{ number_format($report->avg_fare, 0, ',', '.') }}₫</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
