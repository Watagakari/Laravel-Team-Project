<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    
    public function DeletePost(Post $post){
        if(auth()->user() -> id === $post['user_id']){
            if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
            $post -> delete();
        }
        return redirect('/personal');
    }

    public function UpdatePost(Post $post, Request $request){
    // Check if the authenticated user is the owner of the post
    if (auth()->user()->id !== $post['user_id']) {
        return redirect('/personal');
    }

    // Validate the incoming request data
    $edit = $request->validate([
        'title' => 'required',
        'body' => 'required',
        'cp' => 'required', // Validate contact person
        'location' => 'required', // Validate location
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
    ]);

    // Sanitize the input data
    $edit['title'] = strip_tags($edit['title']);
    $edit['body'] = strip_tags($edit['body']);
    $edit['cp'] = strip_tags($edit['cp']); // Sanitize contact person
    $edit['location'] = strip_tags($edit['location']); // Sanitize location

    // Handle the image upload if a new image is provided
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // Store new image
        $imagePath = $request->file('image')->store('images', 'public');
        $edit['image_path'] = $imagePath;
    }

    // Update the post with the new data
    $post->update($edit);

    return redirect('/personal');
}

    public function EditScreen(Post $post){
        if(auth()->user() -> id !== $post['user_id']){
            return redirect('/personal');
        }
        return view('edit-post', ['post' => $post]);
    }
    
    public function createPost(Request $request){
        $post = $request-> validate([
            'title' => 'required',
            'body' => 'required',
            'location' => 'required',
            'cp' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post['title'] = strip_tags($post['title']);
        $post['body'] = strip_tags($post['body']);
        $post['cp'] = strip_tags($request->input('cp')); // Sanitize contact person
        $post['location'] = strip_tags($request->input('location')); // Sanitize location
        $post['user_id'] = auth()->id(); // Set the user ID

        if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public'); // Store the image
        $post['image_path'] = $imagePath; // Save the path to the database
    }

        $post['user_id'] = auth()->id();
        Post::create($post);
        return redirect('/personal');
    }
}
