<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Discovering Bali: The Island of Gods',
                'content' => 'Explore the mystical allure of Bali, known for its vibrant culture, stunning landscapes, and spiritual significance. Learn about the island\'s history and its status as a top travel destination.'
            ],
            [
                'title' => 'Top 10 Must-Visit Temples in Bali',
                'content' => 'A guide to Bali\'s most iconic temples, including Uluwatu, Tanah Lot, and Besakih. Discover their historical and cultural significance.'
            ],
            [
                'title' => 'The Ultimate Bali Travel Itinerary for First-Timers',
                'content' => 'A comprehensive 7-day itinerary for newcomers to Bali, covering key attractions, activities, and local experiences.'
            ],
            [
                'title' => 'Bali\'s Best Beaches: Where to Sunbathe and Swim',
                'content' => 'A review of Bali\'s most beautiful beaches, including Seminyak, Kuta, and Nusa Dua, with tips on where to find the best sun and surf.'
            ],
            [
                'title' => 'Exploring Ubud: Bali’s Cultural Heart',
                'content' => 'Dive into the cultural hub of Ubud, known for its art galleries, traditional markets, and serene rice terraces. Explore the best things to see and do.'
            ],
            [
                'title' => 'Bali\'s Unique Cuisine: Top Dishes You Must Try',
                'content' => 'Discover the flavors of Balinese cuisine, from babi guling (suckling pig) to bebek betutu (slow-cooked duck). Learn about traditional dishes and where to find them.'
            ],
            [
                'title' => 'Adventure Awaits: Top Outdoor Activities in Bali',
                'content' => 'From hiking Mount Batur to white-water rafting on the Ayung River, find out about the best adventure activities Bali has to offer.'
            ],
            [
                'title' => 'A Guide to Bali’s Best Luxury Resorts',
                'content' => 'Explore Bali\'s luxury accommodations, including five-star resorts and private villas. Get insights into top picks for a lavish stay.'
            ],
            [
                'title' => 'The Art and Craft of Bali: Handicrafts and Souvenirs',
                'content' => 'Learn about Bali’s traditional crafts, including batik, silver jewelry, and wood carving. Find out where to buy authentic souvenirs.'
            ],
            [
                'title' => 'Yoga and Wellness Retreats in Bali: A Path to Rejuvenation',
                'content' => 'Explore Bali’s renowned wellness retreats and yoga centers, offering everything from meditation to spa treatments.'
            ],
            [
                'title' => 'Navigating Bali: Tips for Getting Around the Island',
                'content' => 'Understand the best modes of transportation in Bali, from scooters to taxis, and get tips on navigating the island’s roads and traffic.'
            ],
            [
                'title' => 'Bali for Families: Kid-Friendly Activities and Attractions',
                'content' => 'Find out about family-friendly activities in Bali, including water parks, animal sanctuaries, and interactive cultural experiences.'
            ],
            [
                'title' => 'The Best Nightlife Spots in Bali: Where to Go After Dark',
                'content' => 'Explore Bali’s vibrant nightlife, including popular nightclubs, beach bars, and entertainment venues in Seminyak and Kuta.'
            ],
            [
                'title' => 'Eco-Tourism in Bali: Sustainable Travel and Green Initiatives',
                'content' => 'Learn about Bali’s efforts in sustainable tourism, including eco-friendly accommodations, conservation projects, and responsible travel practices.'
            ],
            [
                'title' => 'Bali\'s Spiritual Side: A Guide to Meditation and Spiritual Practices',
                'content' => 'Delve into Bali’s spiritual offerings, from meditation retreats to traditional ceremonies and practices that offer a deeper connection to the island.'
            ],
            [
                'title' => 'Shopping in Bali: Markets, Malls, and Boutiques',
                'content' => 'A guide to the best shopping experiences in Bali, from bustling markets like Ubud Art Market to high-end boutiques in Seminyak.'
            ],
            [
                'title' => 'Romantic Getaways in Bali: Perfect Spots for Couples',
                'content' => 'Discover romantic spots and activities in Bali, including private dinners on the beach, sunset cruises, and couples’ spa treatments.'
            ],
            [
                'title' => 'Bali’s Natural Wonders: Volcanoes, Waterfalls, and Rice Terraces',
                'content' => 'Explore Bali’s natural beauty, from the volcanic landscapes of Mount Batur to the stunning waterfalls and lush rice terraces.'
            ],
            [
                'title' => 'Cultural Festivals and Events in Bali: What to Attend',
                'content' => 'Find out about Bali’s cultural festivals and events throughout the year, including Galungan, Nyepi, and the Bali Arts Festival.'
            ],
        ];

        $available_user_ids = User::pluck('id')->toArray();

        DB::beginTransaction();
        foreach ($posts as $post) {
            $slug            = Str::slug($post['title']);
            $post['slug']    = uniqify_slug($slug);
            $post['user_id'] = $available_user_ids[array_rand($available_user_ids)];
            Post::create($post);
        }
        DB::commit();

        Cache::tags(['posts'])->flush();
    }
}
