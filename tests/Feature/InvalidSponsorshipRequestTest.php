<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvalidSponsorshipRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sponsorship_request_fails_for_non_existing_orphan()
    {
        // إنشاء كافل وهمي
        $kafel = User::factory()->create([
            'role' => 'kafel',
            'password' => bcrypt('password123'),
        ]);

        // تنفيذ الطلب بكائن يتيم غير موجود
        $response = $this->actingAs($kafel)->post('/sponsorship/request', [
            'orphan_id' => 9999, // رقم غير موجود
            'amount' => 100,
            'type' => 'شهري',
        ]);

        // تأكيد أن الطلب فشل بسبب عدم وجود اليتيم
        $response->assertStatus(404);
    }
}
