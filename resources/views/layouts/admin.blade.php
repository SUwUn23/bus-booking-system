<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white p-6 fixed h-full overflow-y-auto">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center font-bold">T</div>
                <div>
                    <div class="font-black text-lg">TANNA</div>
                    <div class="text-xs">Admin</div>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-red-500' : 'hover:bg-slate-800' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.routes.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.routes.*') ? 'bg-red-500' : 'hover:bg-slate-800' }}">
                    🗺 Tuyến đường
                </a>
                <a href="{{ route('admin.trips.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.trips.*') ? 'bg-red-500' : 'hover:bg-slate-800' }}">
                    🚌 Chuyến xe
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-red-500' : 'hover:bg-slate-800' }}">
                    🎫 Đơn đặt vé
                </a>
                <a href="{{ route('admin.reports.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-red-500' : 'hover:bg-slate-800' }}">
                    📈 Báo cáo
                </a>
            </nav>

            <div class="mt-10 pt-6 border-t border-slate-700">
                <p class="text-xs text-slate-400 mb-3">TÀI KHOẢN</p>
                <div class="flex items-center justify-between p-3 bg-slate-800 rounded-lg mb-3">
                    <div>
                        <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-sm font-semibold transition">
                        Đăng xuất
                    </button>
                </form>
                <a href="{{ route('home') }}" class="block w-full px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-sm font-semibold transition mt-2 text-center">
                    ← Trang chủ
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-auto">
            <header class="bg-white shadow sticky top-0 z-40">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-black text-slate-900">@yield('title')</h1>
                    <div class="text-sm text-slate-600">{{ date('d/m/Y H:i') }}</div>
                </div>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
