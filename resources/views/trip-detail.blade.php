@extends('layouts.app')

@section('title', $trip->route->from_city . ' → ' . $trip->route->to_city)

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4">
    <div class="mb-6">
        <a href="{{ route('home') }}" class="text-red-500 hover:text-red-600 font-semibold">&larr; Quay lại</a>
    </div>

    <div class="grid lg:grid-cols-[1.5fr_0.8fr] gap-8">
        <!-- Ghế ngồi -->
        <div class="bg-white rounded-2xl shadow p-8">
            <div class="mb-2">
                <h2 class="text-3xl font-black text-slate-900">{{ $trip->route->from_city }} → {{ $trip->route->to_city }}</h2>
                <p class="text-slate-600 mt-1">{{ $trip->bus_name }} • {{ $trip->license_plate }}</p>
            </div>

            <div class="bg-slate-100 px-4 py-2 rounded-lg mb-6">
                <p class="text-sm text-slate-600">
                    <strong>{{ $trip->departure_time }}</strong> - <strong>{{ $trip->arrival_time }}</strong>
                    • {{ \Carbon\Carbon::parse($trip->departure_date)->format('d/m/Y') }}
                </p>
            </div>

            <div class="mb-8">
                <div class="text-center mb-6">
                    <span class="inline-block px-4 py-2 bg-slate-200 rounded-full text-sm font-semibold text-slate-700">Phía trước (Tài xế)</span>
                </div>

                <div class="grid grid-cols-4 gap-3">
                    @php $groupedSeats = $trip->seats->groupBy(function($seat) { return preg_replace('/[0-9]+/', '', $seat->seat_code); }); @endphp
                    @foreach($trip->seats as $seat)
                        <button
                            type="button"
                            class="seat-btn py-4 px-3 rounded-lg font-bold transition duration-200 text-center text-sm
                                {{ $seat->is_booked ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-green-500 text-white hover:bg-green-600 hover:ring-2 hover:ring-green-300' }}"
                            data-seat="{{ $seat->seat_code }}"
                            data-seat-id="{{ $seat->id }}"
                            @if($seat->is_booked) disabled @endif
                        >
                            {{ $seat->seat_code }}
                        </button>
                    @endforeach
                </div>

                <div class="flex gap-6 mt-8 justify-center text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-green-500 rounded"></div>
                        <span>Còn trống</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-gray-400 rounded"></div>
                        <span>Đã đặt</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-yellow-400 rounded ring-2 ring-yellow-300"></div>
                        <span>Đã chọn</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form đặt vé -->
        <div class="bg-white rounded-2xl shadow p-8 h-fit sticky top-24">
            <h3 class="text-2xl font-bold mb-6">Thông tin hành khách</h3>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                    @foreach($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                <input type="hidden" name="amount" value="{{ $trip->fare }}">
                <input type="hidden" id="selectedSeat" name="seat_code" value="">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Họ và tên *</label>
                        <input name="customer_name" type="text" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ old('customer_name') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Số điện thoại *</label>
                        <input name="phone" type="tel" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input name="email" type="email" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="mt-6 border-t pt-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Ghế chọn</span>
                        <strong id="seatLabel" class="text-slate-900">-</strong>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Giá vé</span>
                        <strong class="text-slate-900">{{ number_format($trip->fare, 0, ',', '.') }}đ</strong>
                    </div>
                    <div class="flex justify-between text-lg border-t pt-3">
                        <span class="font-bold">Tổng cộng</span>
                        <strong class="font-black text-red-500">{{ number_format($trip->fare, 0, ',', '.') }}đ</strong>
                    </div>
                </div>

                @auth
                    <button type="submit" class="mt-6 w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-bold transition" onclick="return validateSeat()">
                        Tiếp tục thanh toán
                    </button>
                @else
                    <div class="mt-6 bg-blue-50 border border-blue-200 p-4 rounded-lg">
                        <p class="text-sm text-blue-900 mb-3">Vui lòng đăng nhập để đặt vé</p>
                        <a href="{{ route('login') }}" class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
                            Đăng nhập / Đăng ký
                        </a>
                    </div>
                @endauth
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.seat-btn:not(:disabled)').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.seat-btn').forEach(el => {
                el.classList.remove('ring-2', 'ring-yellow-300', 'scale-110');
            });
            this.classList.add('ring-2', 'ring-yellow-300', 'scale-110');
            document.getElementById('selectedSeat').value = this.dataset.seat;
            document.getElementById('seatLabel').textContent = this.dataset.seat;
        });
    });

    function validateSeat() {
        if (!document.getElementById('selectedSeat').value) {
            alert('Vui lòng chọn ghế trước khi tiếp tục!');
            return false;
        }
        return true;
    }
</script>
@endsection
