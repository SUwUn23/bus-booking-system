<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->string('bus_name');
            $table->string('license_plate')->unique();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->integer('total_seats')->default(40);
            $table->decimal('fare', 12, 2);
            $table->timestamps();

            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
