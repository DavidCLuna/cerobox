<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_service()
    {
        $response = $this->get('/');

        $user = [
            'email' => 'email@example.org',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $user);

        $service = [
            'name' => 'Test',
            'image' => 'image.jpg',
            'observations' => 'Test',
            'type' => 'Basico',
            'start_date' => '2021-02-10',
            'end_date' => '2021-02-10',
        ];

        $response = $this->post('/api/services', $service);
        
        $response->assertStatus(200);
    }

    public function test_get_service()
    {
        $response = $this->get('/');

        $user = [
            'email' => 'email@example.org',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $user);

        $response = $this->get('/api/services');

        $response->assertStatus(200);

    }
}
