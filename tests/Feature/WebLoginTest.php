<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_shows_login_form_to_guests(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_authenticates_valid_user(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertRedirect('/jobs');
        $this->assertAuthenticatedAs($user);
    }

    public function test_rejects_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'none@example.com',
            'password' => 'bad',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
