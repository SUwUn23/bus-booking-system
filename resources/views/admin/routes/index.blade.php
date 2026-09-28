@extends('layouts.admin')

@section('title', 'Quản lý tuyến đường')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.routes.create') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition">
        + Thêm tuyến đường
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b">
                <th class="px-6 py-3 text-left font-semibold">ID</th>
                <th class="px-6 py-3 text-left font-semibold">Từ</th>
                <th class="px-6 py-3 text-left font-semibold">Đến</th>
                <th class="px-6 py-3 text-left font-semibold">Giá cơ bản</th>
                <th class="px-6 py-3 text-left font-semibold">Chuyến xe</th>
                <th class="px-6 py-3 text-left font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($routes as $route)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-6 py-3 font-semibold">{{ $route->id }}</td>
                    <td class="px-6 py-3">{{ $route->from_city }}</td>
                    <td class="px-6 py-3">{{ $route->to_city }}</td>
                    <td class="px-6 py-3 font-semibold">{{ number_format($route->base_price, 0, ',', '.') }}₫</td>
                    <td class="px-6 py-3">{{ $route->trips->count() }} chuyến</td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.routes.edit', $route->id) }}" class="text-blue-500 hover:text-blue-600 font-semibold mr-3">Sửa</a>
                        <form action="{{ route('admin.routes.destroy', $route->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa?');">
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
    {{ $routes->links() }}
</div>
@endsection
