<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Hamada',
                'email' => 'hamada.undetected@gmail.com',
                'password' => bcrypt('madacoda')
            ],
            [
                'name' => 'Madacoda',
                'email' => 'me@madacoda.dev',
                'password' => bcrypt('madacoda')
            ],
        ];

        foreach($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
