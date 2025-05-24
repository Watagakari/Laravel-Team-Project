<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LibraryController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->savedPosts;
        return view('library', compact('posts'));
    }

    public function save(Post $post)
    {
        $user = auth()->user();

        if (!$user->savedPosts->contains($post->id)) {
            $user->savedPosts()->attach($post->id);
        }

        return back()->with('success', 'Post saved to your library.');
    }

    public function unsave(Post $post)
    {
        $user = auth()->user();
        $user->savedPosts()->detach($post->id);

        return back()->with('success', 'Post removed from your library.');
    }
}
