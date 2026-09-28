@extends('layouts.admin')

@section('title', 'Quản lý đơn đặt vé')

@section('content')
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b">
                <th class="px-6 py-3 text-left font-semibold">Mã vé</th>
                <th class="px-6 py-3 text-left font-semibold">Hành khách</th>
                <th class="px-6 py-3 text-left font-semibold">Tuyến đường</th>
                <th class="px-6 py-3 text-left font-semibold">Ghế</th>
                <th class="px-6 py-3 text-left font-semibold">Giá</th>
                <th class="px-6 py-3 text-left font-semibold">Trạng thái</th>
                <th class="px-6 py-3 text-left font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-6 py-3 font-semibold">{{ $booking->booking_code }}</td>
                    <td class="px-6 py-3">{{ $booking->customer_name }}</td>
                    <td class="px-6 py-3">{{ $booking->trip->route->from_city }} → {{ $booking->trip->route->to_city }}</td>
                    <td class="px-6 py-3 font-semibold text-red-500">{{ $booking->seat_code }}</td>
                    <td class="px-6 py-3 font-semibold">{{ number_format($booking->amount, 0, ',', '.') }}₫</td>
                    <td class="px-6 py-3">
                        <select name="status" onchange="updateStatus(this, {{ $booking->id }})" class="px-3 py-1 rounded-full font-semibold text-sm border-0
                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-500 hover:text-blue-600 font-semibold">Xem chi tiết</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $bookings->links() }}
</div>

<script>
function updateStatus(select, bookingId) {
    const status = select.value;
    fetch(`/admin/bookings/${bookingId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        body: JSON.stringify({ status: status })
    }).then(r => r.json()).then(data => {
        if (data.message) alert(data.message);
    });
}
</script>
@endsection
