<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan pendaftaran mandiri (public registration) dinonaktifkan pada sistem ISP tertutup.
     */
    public function test_registration_screen_is_disabled_and_returns_404(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    /**
     * Memastikan endpoint POST pendaftaran mandiri menolak pembuatan akun publik.
     */
    public function test_registration_endpoint_rejects_post_requests(): void
    {
        $response = $this->post('/register', [
            'name' => 'Intruder',
            'email' => 'intruder@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(404);
        $this->assertGuest();
    }
}
