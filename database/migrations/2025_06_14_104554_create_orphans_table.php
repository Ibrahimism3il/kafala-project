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
        Schema::create('orphans', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->string('name');
            $table->integer('age');
            $table->string('area');
            $table->string('gender')->nullable();
            $table->string('social_status')->nullable();
            $table->string('health_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphans');

    }
};
