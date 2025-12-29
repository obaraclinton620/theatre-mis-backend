<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Production;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $production = Production::factory()->create();

        $response = $this->postJson('/api/auth/register', [
            'production_id' => $production->id,
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(201);
    }
}
