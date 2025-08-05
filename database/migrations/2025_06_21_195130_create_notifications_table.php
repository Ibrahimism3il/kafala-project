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
     Schema::create('notifications', function (Blueprint $table) {
    $table->uuid('id')->primary(); // مفتاح أساسي
    $table->string('type');        // نوع الإشعار (نتركه لأي نوع، سواء تلقائي أو يدوي)
    $table->morphs('notifiable');  // المستخدم المرتبط بالإشعار

    $table->text('data');          // بيانات JSON (Laravel يستخدمها داخلياً)
    $table->string('title')->nullable();     // عنوان مخصص (للاستخدام اليدوي فقط)
    $table->text('content')->nullable();     // محتوى نصي يدوي
    $table->enum('sender_type', ['admin'])->nullable(); // من أرسل الإشعار، حالياً فقط المدير

    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
