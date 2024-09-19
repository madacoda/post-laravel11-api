<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            [
                'comment' => 'Good read! Bali is such a beautiful place with so much to offer.'
            ],
            [
                'comment' => 'I visited the Uluwatu Temple last year, and it was amazing!'
            ],
            [
                'comment' => 'Great itinerary! Can’t wait to try some of these recommendations.'
            ],
            [
                'comment' => 'The beaches in Seminyak are fantastic. Perfect for a relaxing day!'
            ],
            [
                'comment' => 'Ubud is so charming and cultural. Loved the rice terraces!'
            ],
            [
                'comment' => 'Babi guling is my favorite Balinese dish. Delicious!'
            ],
            [
                'comment' => 'I’m planning an adventure trip to Bali soon. Thanks for the tips!'
            ],
            [
                'comment' => 'Staying at a luxury resort in Bali was a dream come true. Highly recommend it!'
            ],
            [
                'comment' => 'The handicrafts in Bali are so unique. Got some great souvenirs!'
            ],
            [
                'comment' => 'I’m really into yoga, so Bali’s retreats are definitely on my list.'
            ],
            [
                'comment' => 'Great tips for getting around! It can be tricky without some guidance.'
            ],
            [
                'comment' => 'Love discovering hidden gems. Amed is so peaceful!'
            ],
            [
                'comment' => 'Family vacations in Bali are always a blast. So many fun activities for kids!'
            ],
            [
                'comment' => 'Seminyak’s nightlife is vibrant and exciting. Enjoyed every minute of it!'
            ],
            [
                'comment' => 'Eco-tourism is so important. Glad to see Bali leading the way!'
            ],
            [
                'comment' => 'Meditation in Bali was a life-changing experience for me.'
            ],
            [
                'comment' => 'Ubud Art Market had so many beautiful things. I loved shopping there!'
            ],
            [
                'comment' => 'Romantic dinners on the beach are unforgettable. Bali is perfect for couples.'
            ],
            [
                'comment' => 'The natural landscapes of Bali are breathtaking. Can’t wait to see more!'
            ],
            [
                'comment' => 'The cultural festivals are such a vibrant experience. Galungan was incredible!'
            ],
        ];

        $available_post_ids = Post::pluck('id')->toArray();
        $available_user_ids = User::pluck('id')->toArray();

        DB::beginTransaction();
        foreach ($comments as $comment) {
            $comment['post_id'] = $available_post_ids[array_rand($available_post_ids)];
            $comment['user_id'] = $available_user_ids[array_rand($available_user_ids)];
            Comment::create($comment);
        }
        DB::commit();
    }
}
