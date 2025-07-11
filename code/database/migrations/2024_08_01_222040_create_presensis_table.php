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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->integer('category');
            $table->integer('status');
            $table->text('description');
            $table->string('device');
            $table->string('platform');
            $table->string('platform_version');
            $table->string('browser');
            $table->string('browser_version');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
