<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateClient extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_client()
    {
        $response = $this->get('/');

        $user = [
            'email' => 'email@example.org',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $user);

        $client = [
            'name' => 'Test',
            'email' => 'email@gmail.com',
            'phone' => '123456789',
            'document' => '123456789',
            'image' => 'image.jpg',
            'observations' => 'Test',
        ];

        $response = $this->post('/api/clients', $client);
        
        $response->assertStatus(200);
    }

    public function test_get_client()
    {
        $response = $this->get('/');

        $user = [
            'email' => 'email@example.org',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $user);

        $response = $this->get('/api/clients');

        $response->assertStatus(200);

    }
}
