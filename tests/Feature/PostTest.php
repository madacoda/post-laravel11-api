<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private $faker;

    public function test_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/posts', [
            'title'   => 'My First Post',
            'content' => 'This is my first post content',
        ]);

        $response->assertStatus(201);
        $this->assertEquals($response->json('data.title'), 'My First Post');
        $this->assertEquals($response->json('data.content'), 'This is my first post content');
    }

    public function test_user_can_update_post(): void
    {
        $user  = User::factory()->create();
        $faker = Faker::create();
        $post  = Post::create([
            'title'   => $faker->sentence,
            'content' => $faker->paragraph,
            'slug'    => $faker->slug,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->patchJson("/api/posts/{$post->id}", [
            'title'   => 'My Updated Post',
            'content' => 'This is my updated post content',
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('data.title'), 'My Updated Post');
        $this->assertEquals($response->json('data.content'), 'This is my updated post content');
    }

    public function test_user_can_delete_post(): void
    {
        $user  = User::factory()->create();
        $faker = Faker::create();
        $post  = Post::create([
            'title'   => $faker->sentence,
            'content' => $faker->paragraph,
            'slug'    => $faker->slug,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(200);
    }

    public function test_user_can_get_all_posts(): void
    {
        $user  = User::factory()->create();
        $faker = Faker::create();
        for ($i = 0; $i < 5; $i++) {
            Post::create([
                'title'   => $faker->sentence,
                'content' => $faker->paragraph,
                'slug'    => $faker->slug,
                'user_id' => $user->id,
            ]);
        }

        $response = $this->actingAs($user)->get('/api/posts');

        $response->assertStatus(200);
    }

    public function test_user_can_find_post(): void
    {
        $user  = User::factory()->create();
        $faker = Faker::create();
        $post  = Post::create([
            'title'   => $faker->sentence,
            'content' => $faker->paragraph,
            'slug'    => $faker->slug,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get("/api/posts/{$post->id}");

        $response->assertStatus(200);
        $this->assertEquals($response->json('data.title'), $post->title);
        $this->assertEquals($response->json('data.content'), $post->content);
    }

    public function test_user_cannot_update_others_post(): void
    {
        $user  = User::factory()->create();
        $faker = Faker::create();
        $post  = Post::create([
            'title'   => $faker->sentence,
            'content' => $faker->paragraph,
            'slug'    => $faker->slug,
        ]);

        $response = $this->actingAs($user)->patchJson("/api/posts/{$post->id}", [
            'title'   => 'My Updated Post',
            'content' => 'This is my updated post content',
        ]);

        $response->assertStatus(status: 401);
    }

    public function test_user_cannot_delete_others_post(): void
    {
        $user  = User::factory()->create();
        $faker = Faker::create();
        $post  = Post::create([
            'title'   => $faker->sentence,
            'content' => $faker->paragraph,
            'slug'    => $faker->slug,
        ]);

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(401);
    }
}
