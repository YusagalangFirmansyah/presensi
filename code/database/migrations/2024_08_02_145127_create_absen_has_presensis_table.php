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
        Schema::create('absen_has_presensis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('absen_id')->unsigned();
            $table->bigInteger('checkin_id')->unsigned();
            $table->bigInteger('checkout_id')->unsigned()->nullable();
            $table->foreign('absen_id')->references('id')->on('absens')->onDelete('cascade');
            $table->foreign('checkin_id')->references('id')->on('presensis')->onDelete('cascade');
            $table->foreign('checkout_id')->references('id')->on('presensis')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_has_presensis');
    }
};
