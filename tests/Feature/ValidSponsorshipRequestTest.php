<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Orphan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidSponsorshipRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
 public function test_sponsorship_request_creates_new_record_for_valid_orphan()
{
    $this->withoutExceptionHandling();

    // إنشاء كافل
    $kafel = User::factory()->create([
        'role' => 'kafel',
    ]);

    // إنشاء مستخدم يتيم
    $orphanUser = User::factory()->create([
        'role' => 'orphan',
    ]);

    // إضافة يتيم فعلي في جدول orphans
    $orphan = \App\Models\Orphan::create([
        'user_id' => $orphanUser->id,
        'name' => $orphanUser->name,
        'age' => 10,
        'area' => 'غزة',
    ]);

    // تنفيذ الطلب مع كل البيانات المطلوبة
    $response = $this->actingAs($kafel)->post('/kafel/sponsorships', [
        'orphan_id' => $orphan->id,
        'type' => 'شهري',
        'amount' => 250,
        'payment_method' => 'نقدي',
    ]);

    // التأكد من إنشاء الكفالة في قاعدة البيانات
    $this->assertDatabaseHas('sponsorships', [
        'kafel_id' => $kafel->id,
        'orphan_id' => $orphan->id,
        'type' => 'شهري',
        'amount' => 250,
    ]);
}

}
