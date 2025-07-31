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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama lokasi, misal "Kantor Pusat"
            $table->decimal('latitude', 10, 8); // Lintang, presisi tinggi
            $table->decimal('longitude', 11, 8); // Bujur, presisi tinggi
            $table->double('radius_km'); // Radius toleransi dalam kilometer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
