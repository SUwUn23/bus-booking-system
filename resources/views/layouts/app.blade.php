<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Bus Booking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .hero-bg {
            background: linear-gradient(rgba(18, 24, 56, 0.9), rgba(18, 24, 56, 0.9)),
                        url('https://images.unsplash.com/photo-1569163139394-de4798aa62b3?w=1200') center/cover no-repeat;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center text-white font-bold text-lg">T</div>
                <div>
                    <div class="font-black text-xl text-blue-900">TANNA</div>
                    <div class="text-xs text-slate-500 uppercase">Travels</div>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-red-500">Book</a>
                <a href="#" class="text-slate-700 hover:text-red-500">Track bus</a>
                <a href="#" class="text-slate-700 hover:text-red-500">My bookings</a>
            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-red-500 font-semibold hover:text-red-600">Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-slate-700 hover:text-red-500">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-red-500">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-700 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-800">Sign up</a>
                @endauth
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg max-w-7xl mx-auto mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg max-w-7xl mx-auto mt-4">
            {{ session('error') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-200 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-white mb-4">About Tanna</h3>
                    <p class="text-sm">Hơn 35 năm dịch vụ vận tải hành khách uy tín tại Việt Nam</p>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-4">Quick Links</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white">Book a ticket</a></li>
                        <li><a href="#" class="hover:text-white">Track bus</a></li>
                        <li><a href="#" class="hover:text-white">My bookings</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-4">Support</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white">Help center</a></li>
                        <li><a href="#" class="hover:text-white">Contact us</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-4">Contact</h3>
                    <p class="text-sm">📞 1900 1234</p>
                    <p class="text-sm">📧 support@tanna.vn</p>
                </div>
            </div>
            <div class="border-t border-slate-700 pt-8 text-center text-sm">
                <p>&copy; 2024 Tanna Travels. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
