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
          Schema::create('sponsorships', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('kafel_id'); // الكافل
        $table->unsignedBigInteger('orphan_id'); // اليتيم
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->string('status')->default('نشطة'); // أو "منتهية"
        $table->timestamps();

        // العلاقات
        $table->foreign('kafel_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('orphan_id')->references('id')->on('orphans')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorships');
    }
};
