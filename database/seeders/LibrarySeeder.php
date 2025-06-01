<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $category = $user->categories()->first();
            $posts = $user->userPosts()->take(2)->get();
            foreach ($posts as $post) {
                \App\Models\Library::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
