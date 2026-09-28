@extends('layouts.admin')

@section('title', 'Sửa tuyến đường')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-8">
    <form action="{{ route('admin.routes.update', $route->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Điểm khởi hành</label>
            <input type="text" name="from_city" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ $route->from_city }}">
            @error('from_city')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Điểm đến</label>
            <input type="text" name="to_city" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ $route->to_city }}">
            @error('to_city')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Giá cơ bản (₫)</label>
            <input type="number" name="base_price" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required min="0" step="1000" value="{{ $route->base_price }}">
            @error('base_price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                Cập nhật
            </button>
            <a href="{{ route('admin.routes.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-900 px-6 py-2 rounded-lg font-semibold transition">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
