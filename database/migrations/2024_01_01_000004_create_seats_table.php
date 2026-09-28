<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->string('seat_code');
            $table->boolean('is_booked')->default(false);
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->unique(['trip_id', 'seat_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
