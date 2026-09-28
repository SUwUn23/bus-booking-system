@extends('layouts.app')

@section('title', 'Vé của tôi')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-black mb-2">Vé của tôi</h1>
    <p class="text-slate-600 mb-8">Quản lý các vé đã đặt và lịch sử đặt vé</p>

    @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6">
                    <div class="grid md:grid-cols-5 gap-4 items-center">
                        <div>
                            <p class="text-xs text-slate-500 uppercase mb-1">Mã vé</p>
                            <p class="font-bold text-slate-900">{{ $booking->booking_code }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 uppercase mb-1">Chuyến</p>
                            <p class="font-bold text-slate-900">{{ $booking->trip->route->from_city }} → {{ $booking->trip->route->to_city }}</p>
                            <p class="text-xs text-slate-600">{{ $booking->trip->departure_time }} • {{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('d/m/Y') }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 uppercase mb-1">Ghế</p>
                            <p class="font-black text-red-500 text-lg">{{ $booking->seat_code }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 uppercase mb-1">Giá</p>
                            <p class="font-bold text-slate-900">{{ number_format($booking->amount, 0, ',', '.') }}đ</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full font-semibold text-sm
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $booking->status === 'confirmed' ? '✓ Đã xác nhận' : ($booking->status === 'cancelled' ? '✗ Đã hủy' : '⏳ Chờ xác nhận') }}
                            </span>
                            <a href="{{ route('booking.show', $booking->id) }}" class="text-red-500 hover:text-red-600 font-semibold ml-4">Xem chi tiết →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow">
            <div class="text-6xl mb-4">🎫</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Bạn chưa có vé nào</h3>
            <p class="text-slate-600 mb-6">Bắt đầu đặt vé để xem chúng tại đây</p>
            <a href="{{ route('home') }}" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 inline-block">Đặt vé ngay</a>
        </div>
    @endif
</div>
@endsection
