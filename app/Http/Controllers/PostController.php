<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function DeletePost(Post $post){
        if(auth()->user() -> id === $post['user_id']){
            $post -> delete();
        }
        return redirect('/');
    }

    public function UpdatePost(Post $post, Request $request){
        if(auth()->user() -> id !== $post['user_id']){
            return redirect('/');
        }

        $edit = $request-> validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $edit['title'] = strip_tags($edit['title']);
        $edit['body'] = strip_tags($edit['body']);

        $post->update($edit);
        return redirect('/');
    }
    public function EditScreen(Post $post){
        if(auth()->user() -> id !== $post['user_id']){
            return redirect('/');
        }
        return view('edit-post', ['post' => $post]);
    }
    public function createPost(Request $request){
        $post = $request-> validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post['title'] = strip_tags($post['title']);
        $post['body'] = strip_tags($post['body']);
        $post['user_id'] = auth()->id();
        Post::create($post);
        return redirect('/');
    }
}
