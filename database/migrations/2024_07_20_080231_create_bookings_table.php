<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('driver_id');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->string('taketime');
            $table->string('fare');
            $table->float('pickup_lat')->nullable();
            $table->float('pickup_lon')->nullable();
            $table->boolean('is_accepted')->nullable();
            $table->boolean('is_finished')->nullable();
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
