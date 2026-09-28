@extends('layouts.app')

@section('title', 'Chi tiết vé')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="mb-8">
        <a href="{{ route('my-bookings') }}" class="text-red-500 hover:text-red-600 font-semibold">&larr; Quay lại</a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-black mb-2">{{ $booking->booking_code }}</h1>
                    <p class="text-blue-100">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <div class="text-sm mb-2">Trạng thái</div>
                    <span class="inline-block px-4 py-2 rounded-full font-bold
                        {{ $booking->status === 'confirmed' ? 'bg-green-400 text-green-900' : ($booking->status === 'cancelled' ? 'bg-red-400 text-red-900' : 'bg-yellow-400 text-yellow-900') }}">
                        {{ $booking->status === 'confirmed' ? 'Đã xác nhận' : ($booking->status === 'cancelled' ? 'Đã hủy' : 'Chờ xác nhận') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-slate-600 text-sm mb-4">CHUYẾN XE</h3>
                    <div class="text-center mb-6">
                        <p class="text-4xl font-black text-slate-900">{{ $booking->trip->departure_time }}</p>
                        <p class="text-slate-600">{{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('d/m/Y') }}</p>
                    </div>
                    <p class="text-xl font-bold text-slate-900">{{ $booking->trip->route->from_city }}</p>
                    <p class="text-sm text-slate-600 mb-4">{{ $booking->trip->bus_name }}</p>
                    <p class="text-xl font-bold text-slate-900">{{ $booking->trip->route->to_city }}</p>
                    <p class="text-sm text-slate-600">Ghế: <strong class="text-red-500 text-lg">{{ $booking->seat_code }}</strong></p>
                </div>

                <div>
                    <h3 class="font-bold text-slate-600 text-sm mb-4">HÀNH KHÁCH</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-slate-600">Họ và tên</p>
                            <p class="text-lg font-bold text-slate-900">{{ $booking->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Số điện thoại</p>
                            <p class="text-lg font-bold text-slate-900">{{ $booking->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Email</p>
                            <p class="text-lg font-bold text-slate-900">{{ $booking->email ?: 'Không có' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t pt-8 grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-bold text-slate-600 text-sm mb-4">THANH TOÁN</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Giá vé</span>
                            <strong>{{ number_format($booking->amount, 0, ',', '.') }}đ</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Phí dịch vụ</span>
                            <strong>0đ</strong>
                        </div>
                        <div class="flex justify-between text-lg border-t pt-2 mt-2">
                            <span class="font-bold">Tổng cộng</span>
                            <strong class="text-red-500">{{ number_format($booking->amount, 0, ',', '.') }}đ</strong>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-slate-600 text-sm mb-4">HÀNH ĐỘNG</h3>
                    @if($booking->status === 'confirmed')
                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy vé? Tiền sẽ được hoàn lại trong 3-5 ngày');">
                            @csrf
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-semibold transition">
                                Hủy vé
                            </button>
                        </form>
                        <p class="text-xs text-slate-600 mt-2">Hoàn tiền 100% nếu hủy trước 6 giờ khởi hành</p>
                    @elseif($booking->status === 'cancelled')
                        <p class="text-slate-600">Vé đã hủy. Tiền sẽ được hoàn lại trong 3-5 ngày.</p>
                    @else
                        <a href="{{ route('booking.checkout', $booking->id) }}" class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
                            Hoàn thành thanh toán
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
