<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('booking_code')->unique();
            $table->string('seat_code');
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
