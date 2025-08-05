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
        $table->integer('age')->nullable(); // فقط لليتيم
        $table->enum('social_status', ['يتيم الأب', 'يتيم الأبوين'])->nullable();
        $table->enum('health_status', ['سليم', 'مريض'])->nullable();
        $table->string('document')->nullable(); // اسم الملف
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'age', 'social_status', 'health_status', 'document']);
    });
    }
};
