@extends('layouts.admin')

@section('title', 'Thêm chuyến xe')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-8">
    <form action="{{ route('admin.trips.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tuyến đường</label>
            <select name="route_id" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <option value="">Chọn tuyến đường</option>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}">{{ $route->from_city }} → {{ $route->to_city }}</option>
                @endforeach
            </select>
            @error('route_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tên xe</label>
            <input type="text" name="bus_name" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
            @error('bus_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Biển số xe</label>
            <input type="text" name="license_plate" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
            @error('license_plate')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày khởi hành</label>
                <input type="date" name="departure_date" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                @error('departure_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Số ghế</label>
                <input type="number" name="total_seats" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required min="20" max="60" value="40">
                @error('total_seats')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Giờ khởi hành</label>
                <input type="time" name="departure_time" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                @error('departure_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Giờ đến</label>
                <input type="time" name="arrival_time" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                @error('arrival_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Giá vé (₫)</label>
            <input type="number" name="fare" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required min="0" step="1000">
            @error('fare')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                Lưu
            </button>
            <a href="{{ route('admin.trips.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-900 px-6 py-2 rounded-lg font-semibold transition">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
