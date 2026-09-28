@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900">Xác nhận thanh toán</h1>
        <p class="text-slate-600 mt-2">Mã đặt vé: <strong>{{ $booking->booking_code }}</strong></p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <!-- Thông tin chuyến -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Chi tiết chuyến xe</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Tuyến đường</span>
                        <strong>{{ $booking->trip->route->from_city }} → {{ $booking->trip->route->to_city }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Giờ khởi hành</span>
                        <strong>{{ $booking->trip->departure_time }} • {{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('d/m/Y') }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Xe</span>
                        <strong>{{ $booking->trip->bus_name }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Ghế</span>
                        <strong class="text-red-500 font-black text-lg">{{ $booking->seat_code }}</strong>
                    </div>
                </div>
            </div>

            <!-- Thông tin hành khách -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
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
                        <strong>{{ $booking->email ?: 'Chưa có' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold mb-4">Chọn phương thức thanh toán</h2>
                <form action="{{ route('payment.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-red-300 hover:bg-red-50 transition">
                            <input type="radio" name="method" value="credit_card" class="w-5 h-5 text-red-500" required>
                            <span class="ml-3 font-semibold">Thẻ tín dụng / Ghi nợ</span>
                        </label>

                        <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-red-300 hover:bg-red-50 transition">
                            <input type="radio" name="method" value="bank_transfer" class="w-5 h-5 text-red-500">
                            <span class="ml-3 font-semibold">Chuyển khoản ngân hàng</span>
                        </label>

                        <label class="flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-red-300 hover:bg-red-50 transition">
                            <input type="radio" name="method" value="e_wallet" class="w-5 h-5 text-red-500">
                            <span class="ml-3 font-semibold">Ví điện tử (Momo, ZaloPay)</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-bold text-lg transition">
                        Thanh toán ngay
                    </button>
                </form>
            </div>
        </div>

        <!-- Tóm tắt giá -->
        <div class="bg-white rounded-xl shadow p-6 h-fit sticky top-24">
            <h3 class="text-lg font-bold mb-4">Tóm tắt đơn hàng</h3>

            <div class="space-y-3 text-sm border-b pb-4 mb-4">
                <div class="flex justify-between">
                    <span>Giá vé</span>
                    <strong>{{ number_format($booking->amount, 0, ',', '.') }}đ</strong>
                </div>
                <div class="flex justify-between">
                    <span>Phí dịch vụ</span>
                    <strong>0đ</strong>
                </div>
                <div class="flex justify-between">
                    <span>Bảo hiểm</span>
                    <strong>0đ</strong>
                </div>
            </div>

            <div class="flex justify-between text-lg mb-6">
                <span class="font-bold">Tổng thanh toán</span>
                <strong class="text-red-500 font-black text-2xl">{{ number_format($booking->amount, 0, ',', '.') }}đ</strong>
            </div>

            <div class="bg-green-50 border border-green-200 p-3 rounded-lg">
                <p class="text-xs text-green-800">
                    ✓ Hoàn tiền 100% nếu hủy trước 6 giờ khởi hành
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
