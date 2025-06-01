<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        $libraryPosts = Library::with(['post.user'])
            ->where('user_id', auth()->id())
            ->get()
            ->pluck('post');

        if (request()->wantsJson()) {
            return response()->json($libraryPosts);
        }

        $categories = auth()->user()->categories()
            ->with(['posts' => function($query) {
                $query->with('user')
                    ->orderBy('created_at', 'desc');
            }])
            ->get();

        return view('library', compact('categories'));
    }

    public function store(Request $request, Post $post)
    {
        // Check if post is already in user's library
        $exists = Library::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->exists();

        if ($exists) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Post already in your library'
                ], 400);
            }
            return back()->with('error', 'Post already in your library');
        }

        // Validate category_id
        $request->validate([
            'category_id' => 'required|exists:categories,id'
        ]);

        // Add post to library
        Library::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'category_id' => $request->category_id
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Post added to library successfully'
            ]);
        }
        return back()->with('success', 'Post added to library successfully');
    }

    public function destroy(Post $post)
    {
        Library::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Post removed from library successfully'
            ]);
        }
        return back()->with('success', 'Post removed from library successfully');
    }

    public function save(Post $post)
    {
        try {
            // Check if post is already saved
            if ($post->savedByUsers->contains(auth()->id())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post already saved'
                ], 422);
            }

            // Validate category_id
            $categoryId = request('category_id');
            if (!$categoryId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category is required'
                ], 422);
            }

            // Check if category exists and belongs to user
            $category = auth()->user()->categories()->find($categoryId);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            // Save post to library with category
            auth()->user()->savedPosts()->attach($post->id, [
                'category_id' => $categoryId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post saved successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saving post: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save post: ' . $e->getMessage()
            ], 500);
        }
    }

    public function unsave(Post $post)
    {
        $user = Auth::user();
        
        // Remove from user's saved posts
        $user->savedPosts()->detach($post->id);
        
        // Remove from all user's categories
        $user->categories()->each(function ($category) use ($post) {
            $category->posts()->detach($post->id);
        });

        return back()->with('success', 'Post removed from library');
    }
}
