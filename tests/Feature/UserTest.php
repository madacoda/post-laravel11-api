<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_cache(): void
    {
        $response = $this->get('/api/clear-cache');

        $response->assertStatus(200);
    }

    function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'John Cena',
            'email'    => 'johncena@ofcourseitstest.com',
            'password' => 'teteretew',
        ]);

        $response->assertStatus(201);
        $this->assertEquals($response->json('data.name'), 'John Cena');
        $this->assertEquals($response->json('data.email'), 'johncena@ofcourseitstest.com');
        $this->assertNotNull($response->json('data.token'));
    }

    function test_user_can_login(): void
    {
        $user = User::create([
            'name'     => 'John Cena',
            'email'    => 'johncena@ofcourseitstest.com',
            'password' => bcrypt('teteretew'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'teteretew',
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('data.email'), $user->email);
        $this->assertNotNull($response->json('data.token'));
    }

    function test_user_can_logout(): void
    {
        $user = User::create([
            'name'     => 'John Cena',
            'email'    => 'johncena@ofcourseitstest.com',
            'password' => bcrypt('teteretew'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'teteretew',
        ]);

        $response->assertStatus(200);

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $response->json('data.token'),
        ]);

        $response->assertStatus(200);
    }
}
