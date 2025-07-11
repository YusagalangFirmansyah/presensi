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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->bigInteger('division_id')->unsigned()->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('set null');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropForeign(['division_id']);
            $table->dropColumn('division_id');
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
