<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('href="' . route('our-services') . '">Explore Services</a>', false);
        $response->assertSee('id="clients-title"', false);
        $response->assertSee('Tower Xchange Africa');
        $response->assertSee(asset('images/clients/safaricom.webp'), false);
        $response->assertSee('data-clients-carousel', false);
        $response->assertSee('data-client-count="7"', false);
    }
}
