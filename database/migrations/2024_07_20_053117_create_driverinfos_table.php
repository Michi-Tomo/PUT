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
        Schema::create('driverinfos', function (Blueprint $table) {
            $table->id();
            $table->string('driver_image');
            $table->integer('age');
            $table->string('driver_license');
            $table->string('license_plate');
            $table->foreignId('user_id')->constrained();
            $table->float('location_lat')->nullable();
            $table->float('location_lon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driverinfos');
    }
};
