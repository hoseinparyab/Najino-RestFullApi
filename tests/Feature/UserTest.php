<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Ensure the database is migrated
        $this->artisan('migrate');
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
    }

    public function test_can_list_users(): void
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/admin/users');

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data'); // 3 created + 1 from setup
    }
}
