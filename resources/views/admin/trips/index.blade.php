@extends('layouts.admin')

@section('title', 'Quản lý chuyến xe')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.trips.create') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition">
        + Thêm chuyến xe
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b">
                <th class="px-6 py-3 text-left font-semibold">Tuyến đường</th>
                <th class="px-6 py-3 text-left font-semibold">Tên xe</th>
                <th class="px-6 py-3 text-left font-semibold">Ngày khởi hành</th>
                <th class="px-6 py-3 text-left font-semibold">Giờ</th>
                <th class="px-6 py-3 text-left font-semibold">Ghế trống</th>
                <th class="px-6 py-3 text-left font-semibold">Giá</th>
                <th class="px-6 py-3 text-left font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-6 py-3 font-semibold">{{ $trip->route->from_city }} → {{ $trip->route->to_city }}</td>
                    <td class="px-6 py-3">{{ $trip->bus_name }}</td>
                    <td class="px-6 py-3">{{ $trip->departure_date->format('d/m/Y') }}</td>
                    <td class="px-6 py-3">{{ $trip->departure_time }} - {{ $trip->arrival_time }}</td>
                    <td class="px-6 py-3"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold text-xs">{{ $trip->availableSeats() }}</span></td>
                    <td class="px-6 py-3 font-semibold">{{ number_format($trip->fare, 0, ',', '.') }}₫</td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.trips.edit', $trip->id) }}" class="text-blue-500 hover:text-blue-600 font-semibold mr-3">Sửa</a>
                        <form action="{{ route('admin.trips.destroy', $trip->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 font-semibold">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $trips->links() }}
</div>
@endsection
