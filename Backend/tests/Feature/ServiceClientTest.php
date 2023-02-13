<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceClientTest extends TestCase
{
  
    public function test_create_service_client()
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

        $responseServices = $this->post('/api/services', $service);

        $client = [
            'name' => 'Test',
            'email' => 'client1@gmail.com',
            'phone' => '123456789',
            'document' => '123456789',
            'image' => 'image.jpg',
            'observations' => 'Test',
        ];

        $responseClients = $this->post('/api/clients', $client);

        $client_service = [
            'services' => [$responseServices->json('data')['id']],
            'client_id' => $responseClients->json('data')['id'],
            'position' => 1,
        ];

        $response = $this->post('/api/service-clients', $client_service);

        $response->assertStatus(200);

    }

    public function test_get_service_client()
    {
        $response = $this->get('/');

        $user = [
            'email' => 'email@example.org',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $user);

        $response = $this->get('/api/service-clients');

        $response->assertStatus(200);
    }
}
