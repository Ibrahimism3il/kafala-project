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
           Schema::table('sponsorships', function (Blueprint $table) {
        // نحذف الأعمدة التي تسبب خطأ لأنها موجودة مسبقًا
        if (!Schema::hasColumn('sponsorships', 'type')) {
            $table->string('type')->nullable();
        }

        if (!Schema::hasColumn('sponsorships', 'amount')) {
            $table->decimal('amount', 8, 2)->nullable();
        }

        if (!Schema::hasColumn('sponsorships', 'end_date')) {
            $table->date('end_date')->nullable();
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsorships', function (Blueprint $table) {
            //
        });
    }
};
