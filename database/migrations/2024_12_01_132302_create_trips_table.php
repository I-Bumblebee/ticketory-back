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
            $table->foreignId('route_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->dateTime('departure_time');
            $table->unsignedInteger('trip_duration_minutes');
            $table->json('seat_pricing');
            $table->timestamps();

            $table->unique(['route_id', 'vehicle_id', 'departure_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
