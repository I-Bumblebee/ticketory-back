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
            $table->foreignId('vehicle_id')->constrained();
            $table->string('seat_identifier');
            $table->string('class');
            $table->timestamps();

            $table->unique(['vehicle_id', 'seat_identifier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
