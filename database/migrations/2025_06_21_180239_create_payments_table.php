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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // الكفالة المرتبطة بالدفع
            $table->foreignId('sponsorship_id')
                ->constrained()
                ->onDelete('cascade');

            // الكافل (المتبرع)
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // مبلغ الدفع
            $table->decimal('amount', 10, 2);

            // تاريخ الدفع (يمكن أن يكون NULL إلى حين التأكيد)
            $table->date('payment_date')->nullable();

            // وسيلة الدفع: نقدًا، تحويل، PayPal...
            $table->string('method');

            // حالة الدفع: معلق، مقبول، مرفوض
            $table->string('status')->default('معلق');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
