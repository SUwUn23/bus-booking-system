@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-slate-600 mb-2">Doanh thu hôm nay</p>
        <p class="text-3xl font-black text-red-500">{{ number_format($todayRevenue, 0, ',', '.') }}₫</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-slate-600 mb-2">Tổng đặt vé</p>
        <p class="text-3xl font-black text-blue-500">{{ $totalBookings }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-slate-600 mb-2">Chuyến xe</p>
        <p class="text-3xl font-black text-green-500">{{ $totalTrips }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-slate-600 mb-2">Tổng doanh thu</p>
        <p class="text-3xl font-black text-purple-500">{{ number_format($totalRevenue, 0, ',', '.') }}₫</p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8 mb-8">
    <!-- Biểu đồ doanh thu 7 ngày -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Doanh thu 7 ngày gần nhất</h2>
        <canvas id="revenueChart"></canvas>
    </div>

    <!-- Biểu đồ số lượng đặt vé -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Số đặt vé 7 ngày gần nhất</h2>
        <canvas id="bookingsChart"></canvas>
    </div>
</div>

<!-- Đơn đặt vé gần đây -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="text-lg font-bold">Đơn đặt vé gần đây</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b">
                    <th class="px-6 py-3 text-left font-semibold">Mã vé</th>
                    <th class="px-6 py-3 text-left font-semibold">Hành khách</th>
                    <th class="px-6 py-3 text-left font-semibold">Tuyến đường</th>
                    <th class="px-6 py-3 text-left font-semibold">Giá</th>
                    <th class="px-6 py-3 text-left font-semibold">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold">{{ $booking->booking_code }}</td>
                        <td class="px-6 py-3">{{ $booking->customer_name }}</td>
                        <td class="px-6 py-3">{{ $booking->trip->route->from_city }} → {{ $booking->trip->route->to_city }}</td>
                        <td class="px-6 py-3 font-semibold">{{ number_format($booking->amount, 0, ',', '.') }}₫</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $booking->status === 'confirmed' ? 'Đã xác nhận' : 'Chờ xác nhận' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Doanh thu chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($chartData->pluck('date')),
            datasets: [{
                label: 'Doanh thu (₫)',
                data: @json($chartData->pluck('revenue')),
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#ef4444'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Số lượng đặt vé chart
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingsCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData->pluck('date')),
            datasets: [{
                label: 'Số đặt vé',
                data: @json($chartData->pluck('count')),
                backgroundColor: '#3b82f6',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
