<?php

namespace Tests\Feature;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_creates_a_redirect()
    {
        $redirectData = Redirect::factory()->make()->toArray();
        $response = $this->json('POST', '/api/redirects', $redirectData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('redirects', $redirectData);
    }

    /** @test */
    public function it_creates_a_redirect_with_valid_url()
    {
        $redirectData = Redirect::factory()->make([
            'url' => $this->faker->url,
        ])->toArray();
        $response = $this->json('POST', '/api/redirects', $redirectData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('redirects', $redirectData);
    }

    // Adicione mais testes conforme necessário
}
