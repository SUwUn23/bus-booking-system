@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full bg-red-500 flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">T</div>
                <h1 class="text-3xl font-black text-slate-900">Tanna Travels</h1>
                <p class="text-slate-600 mt-2">Đặt vé xe khách trực tuyến</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Mật khẩu</label>
                    <input type="password" name="password" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-red-500">
                    <label for="remember" class="ml-2 text-sm text-slate-600">Ghi nhớ tôi</label>
                </div>

                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-bold transition">
                    Đăng nhập
                </button>
            </form>

            <p class="text-center text-slate-600 text-sm mt-6">
                Chưa có tài khoản? <a href="{{ route('register') }}" class="text-red-500 hover:text-red-600 font-semibold">Đăng ký ngay</a>
            </p>

            <div class="mt-6 pt-6 border-t">
                <p class="text-xs text-slate-500 text-center">Tài khoản demo:</p>
                <p class="text-xs text-slate-600 text-center mt-1">Email: admin@example.com | Pass: password</p>
                <p class="text-xs text-slate-600 text-center">Email: customer@example.com | Pass: password</p>
            </div>
        </div>
    </div>
</div>
@endsection
