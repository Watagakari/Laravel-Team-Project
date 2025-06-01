<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            for ($i = 1; $i <= 3; $i++) {
                $user->userPosts()->create([
                    'title' => "Post {$i} by {$user->name}",
                    'body' => "This is the content of post {$i} by {$user->name}.",
                    'cp' => "08{$i}1234567{$i}",
                    'location' => "City {$i}",
                    'image_path' => "https://source.unsplash.com/400x300/?nature,water,city,random&sig={$user->id}{$i}",
                ]);
            }
        }
    }
}
