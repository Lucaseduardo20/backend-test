<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectApiTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_the_application_returns_a_successful_response()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function it_creates_a_redirect_with_valid_url()
    {
        $validUrl = 'https://localhost:8080';
        $redirectData = [
            'url' => $validUrl,
        ];

        $response = $this->json('POST', '/api/redirects', $redirectData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('redirects', $redirectData);
    }

    public function it_fails_to_create_a_redirect_with_invalid_dns()
    {
        $invalidUrl = 'https://invalid-url';
        $redirectData = [
            'url' => $invalidUrl,
        ];

        $response = $this->json('POST', '/api/redirects', $redirectData);

        $response->assertStatus(422);
    }

    public function it_fails_to_create_a_redirect_with_invalid_url()
    {
        $invalidUrl = 'https://invalid-url';
        $redirectData = [
            'url' => $invalidUrl,
        ];

        $response = $this->json('POST', '/api/redirects', $redirectData);

        $response->assertStatus(422);
    }
}
