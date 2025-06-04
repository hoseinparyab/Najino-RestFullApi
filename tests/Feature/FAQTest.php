<?php

namespace Tests\Feature;

use App\Models\FAQ;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FAQTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Ensure the database is migrated
        $this->artisan('migrate');
        // Seed the database with test data
        $this->artisan('db:seed', ['--class' => 'FAQSeeder']);
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
    }

    public function test_can_list_faqs(): void
    {
        FAQ::factory()->count(3)->create();

        $response = $this->getJson('/api/faqs');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links']);
    }

    public function test_can_create_faq(): void
    {
        $faqData = [
            'question' => 'Test Question',
            'answer' => 'Test Answer',
            'is_active' => true,
        ];

        $response = $this->postJson('/api/admin/faqs', $faqData);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'question', 'answer', 'is_active']);
        $this->assertDatabaseHas('faqs', $faqData);
    }

    public function test_can_show_faq(): void
    {
        $faq = FAQ::factory()->create();

        $response = $this->getJson('/api/admin/faqs/' . $faq->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'question', 'answer', 'is_active']);
    }

    public function test_can_update_faq(): void
    {
        $faq = FAQ::factory()->create();
        $updatedData = [
            'question' => 'Updated Question',
            'answer' => 'Updated Answer',
            'is_active' => false,
        ];

        $response = $this->putJson('/api/admin/faqs/' . $faq->id, $updatedData);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'question', 'answer', 'is_active']);
        $this->assertDatabaseHas('faqs', $updatedData);
    }

    public function test_can_delete_faq(): void
    {
        $faq = FAQ::factory()->create();

        $response = $this->deleteJson('/api/admin/faqs/' . $faq->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'FAQ deleted successfully']);
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
