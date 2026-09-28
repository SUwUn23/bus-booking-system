@extends('layouts.admin')

@section('title', 'Chi tiết đơn đặt vé')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Thông tin vé</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Mã vé</span>
                    <strong>{{ $booking->booking_code }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Tuyến đường</span>
                    <strong>{{ $booking->trip->route->from_city }} → {{ $booking->trip->route->to_city }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Ngày khởi hành</span>
                    <strong>{{ $booking->trip->departure_date->format('d/m/Y') }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Giờ khởi hành</span>
                    <strong>{{ $booking->trip->departure_time }} - {{ $booking->trip->arrival_time }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Ghế</span>
                    <strong class="text-red-500 font-black">{{ $booking->seat_code }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Xe</span>
                    <strong>{{ $booking->trip->bus_name }}</strong>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Thông tin hành khách</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Họ và tên</span>
                    <strong>{{ $booking->customer_name }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Số điện thoại</span>
                    <strong>{{ $booking->phone }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Email</span>
                    <strong>{{ $booking->email ?: 'Không có' }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 h-fit">
        <h2 class="text-lg font-bold mb-4">Thống kê</h2>
        <div class="space-y-4">
            <div class="bg-slate-50 p-4 rounded-lg">
                <p class="text-xs text-slate-600 mb-1">Giá vé</p>
                <p class="text-2xl font-black text-red-500">{{ number_format($booking->amount, 0, ',', '.') }}₫</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-lg">
                <p class="text-xs text-slate-600 mb-1">Ngày đặt</p>
                <p class="font-semibold">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Trạng thái</label>
                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-semibold transition">
                        Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
