# Bus Booking System

Website đặt vé xe khách trực tuyến xây dựng bằng Laravel MVC + MySQL.

## Cài đặt

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

## Tài khoản test

**Admin:**
- Email: admin@example.com
- Password: password

**Customer:**
- Email: customer@example.com
- Password: password

## Chức năng chính

- Tìm kiếm chuyến xe theo nơi đi, nơi đến, ngày đi
- Chọn ghế trực tiếp
- Đặt vé và thanh toán
- Quản lý vé đã đặt
- Admin dashboard: quản lý tuyến, chuyến, doanh thu
- Báo cáo theo ngày/tháng

## Cấu trúc thư mục

```
app/
├── Models/
│   ├── Route.php
│   ├── Trip.php
│   ├── Seat.php
│   ├── Booking.php
│   ├── User.php
│   └── Payment.php
├── Http/Controllers/
│   ├── HomeController.php
│   ├── BookingController.php
│   ├── Admin/
│   │   ├── RouteController.php
│   │   ├── TripController.php
│   │   ├── BookingController.php
│   │   └── ReportController.php
│   └── AuthController.php
└── Mail/
    └── BookingConfirmation.php

resources/views/
├── layouts/
│   ├── app.blade.php
│   └── admin.blade.php
├── home.blade.php
├── trip-detail.blade.php
├── checkout.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── routes/
│   ├── trips/
│   ├── bookings/
│   └── reports/
└── auth/
    ├── login.blade.php
    └── register.blade.php

database/
├── migrations/
│   ├── create_users_table.php
│   ├── create_routes_table.php
│   ├── create_trips_table.php
│   ├── create_seats_table.php
│   ├── create_bookings_table.php
│   └── create_payments_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── RouteSeeder.php
    ├── TripSeeder.php
    ├── SeatSeeder.php
    └── UserSeeder.php

routes/
├── web.php
├── api.php
└── admin.php
```

## Database Schema

### routes
- id, from_city, to_city, base_price, created_at, updated_at

### trips
- id, route_id, bus_name, license_plate, departure_date, departure_time, arrival_time, total_seats, fare, created_at, updated_at

### seats
- id, trip_id, seat_code, is_booked, created_at, updated_at

### bookings
- id, trip_id, user_id, seat_code, customer_name, phone, email, amount, status, created_at, updated_at

### payments
- id, booking_id, method, amount, status, transaction_id, created_at, updated_at

## Tính năng nâng cao

- Email xác nhận đặt vé
- QR code trên vé
- Theo dõi xe real-time (GPS mock)
- Hủy vé + hoàn tiền tự động
- Báo cáo doanh thu chi tiết
