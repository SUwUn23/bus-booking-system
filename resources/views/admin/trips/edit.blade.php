@extends('layouts.admin')

@section('title', 'Sửa chuyến xe')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-8">
    <form action="{{ route('admin.trips.update', $trip->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tuyến đường</label>
            <select name="route_id" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}" {{ $trip->route_id === $route->id ? 'selected' : '' }}>{{ $route->from_city }} → {{ $route->to_city }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tên xe</label>
            <input type="text" name="bus_name" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ $trip->bus_name }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Biển số xe</label>
            <input type="text" name="license_plate" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ $trip->license_plate }}">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày khởi hành</label>
                <input type="date" name="departure_date" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ $trip->departure_date->format('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Số ghế</label>
                <input type="number" name="total_seats" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required min="20" max="60" value="{{ $trip->total_seats }}">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Giờ khởi hành</label>
                <input type="time" name="departure_time" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ $trip->departure_time }}">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Giờ đến</label>
                <input type="time" name="arrival_time" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ $trip->arrival_time }}">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Giá vé (₫)</label>
            <input type="number" name="fare" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required min="0" step="1000" value="{{ $trip->fare }}">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                Cập nhật
            </button>
            <a href="{{ route('admin.trips.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-900 px-6 py-2 rounded-lg font-semibold transition">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
