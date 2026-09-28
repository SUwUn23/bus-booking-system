@extends('layouts.app')

@section('title', 'Đặt vé xe khách')

@section('content')
<section class="hero-bg min-h-[700px] flex items-center">
    <div class="max-w-7xl mx-auto px-4 w-full">
        <div class="text-white">
            <p class="mb-4 text-sm tracking-wide uppercase text-slate-200">Toàn quốc • 35 năm dịch vụ uy tín</p>
            <h1 class="text-5xl md:text-6xl font-black leading-tight">
                Đặt vé xe khách <span class="text-yellow-400">trực tuyến</span> <br>
                nhanh chóng & tiện lợi
            </h1>
            <p class="mt-6 text-lg text-slate-200 max-w-2xl">
                Hàng chục chuyến xe khách mỗi ngày, ghế từ 120.000đ, đặt vé dễ dàng chỉ trong 1 phút.
            </p>

            <form action="{{ route('search') }}" method="GET" class="mt-8 bg-white p-6 rounded-2xl shadow-xl max-w-4xl">
                <div class="grid md:grid-cols-[1fr_1fr_1fr_auto] gap-4 items-end">
                    <div>
                        <label class="block text-sm text-slate-600 font-semibold mb-2">Từ (Nơi đi)</label>
                        <select name="from" class="w-full border border-slate-300 rounded-lg h-12 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                            <option value="">Chọn nơi đi</option>
                            <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Cần Thơ">Cần Thơ</option>
                            <option value="Hải Phòng">Hải Phòng</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-slate-600 font-semibold mb-2">Đến (Nơi đến)</label>
                        <select name="to" class="w-full border border-slate-300 rounded-lg h-12 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                            <option value="">Chọn nơi đến</option>
                            <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Cần Thơ">Cần Thơ</option>
                            <option value="Hải Phòng">Hải Phòng</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-slate-600 font-semibold mb-2">Ngày đi</label>
                        <input type="date" name="travel_date" class="w-full border border-slate-300 rounded-lg h-12 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ date('Y-m-d') }}">
                    </div>

                    <button type="submit" class="h-12 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg px-6 transition">
                        Tìm chuyến
                    </button>
                </div>

                <div class="mt-4 flex flex-wrap gap-3 text-slate-600 text-sm">
                    <span>📍 Hàng trăm điểm đón/trả khắp toàn quốc</span>
                    <span>⏱ Hoàn tiền 100% nếu hủy trước 6 giờ</span>
                    <span>⭐ Có chỗ dành cho nữ hành khách</span>
                </div>
            </form>
        </div>
    </div>
</section>

<main class="max-w-7xl mx-auto px-4 py-16">
    @if(isset($searched))
        <div class="mb-8">
            <h2 class="text-3xl font-black mb-2">Kết quả tìm kiếm</h2>
            <p class="text-slate-600">{{ $from }} → {{ $to }} • {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
        </div>
    @else
        <div class="mb-8">
            <h2 class="text-3xl font-black mb-2">Chuyến xe sắp tới</h2>
            <p class="text-slate-600">Những chuyến xe phổ biến trong tuần này</p>
        </div>
    @endif

    @if($trips->count() > 0)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="grid grid-cols-5 text-sm font-semibold text-slate-600 bg-slate-50 border-b">
                <div class="px-6 py-4">Khởi hành</div>
                <div class="px-6 py-4">Đến nơi</div>
                <div class="px-6 py-4">Ghế trống</div>
                <div class="px-6 py-4">Giá vé</div>
                <div class="px-6 py-4 text-right">Hành động</div>
            </div>

            @foreach($trips as $trip)
                <div class="grid grid-cols-5 px-6 py-5 border-b hover:bg-slate-50 items-center transition">
                    <div>
                        <div class="font-bold text-lg text-slate-900">{{ $trip->departure_time }}</div>
                        <div class="text-xs text-slate-500">{{ $trip->route->from_city }}</div>
                    </div>
                    <div>
                        <div class="font-bold text-lg text-slate-900">{{ $trip->arrival_time }}</div>
                        <div class="text-xs text-slate-500">{{ $trip->route->to_city }}</div>
                    </div>
                    <div>
                        <div class="font-bold text-lg text-red-500">{{ $trip->availableSeats() }}</div>
                        <div class="text-xs text-slate-500">ghế trống</div>
                    </div>
                    <div>
                        <div class="font-bold text-lg text-slate-900">{{ number_format($trip->fare, 0, ',', '.') }}đ</div>
                        <div class="text-xs text-slate-500">từ giá này</div>
                    </div>
                    <div class="text-right">
                        @if($trip->availableSeats() > 0)
                            <a href="{{ route('trip.show', $trip->id) }}" class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600 transition font-semibold">
                                Đặt vé
                            </a>
                        @else
                            <button disabled class="bg-slate-300 text-slate-600 px-5 py-2 rounded-lg cursor-not-allowed font-semibold">
                                Hết vé
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">😢</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Không tìm thấy chuyến xe</h3>
            <p class="text-slate-600 mb-6">Vui lòng thử tìm kiếm với các tiêu chí khác</p>
            <a href="{{ route('home') }}" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 inline-block">Quay lại tìm kiếm</a>
        </div>
    @endif
</main>
@endsection
