<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'category_id' => 'required|exists:bookmark_categories,id',
        ]);

        $bookmark = Bookmark::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'bookmark_category_id' => $request->category_id,
        ]);

        return response()->json([
            'message' => 'Post bookmarked successfully',
            'bookmark' => $bookmark
        ]);
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = BookmarkCategory::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    public function getCategories()
    {
        $categories = BookmarkCategory::where('user_id', Auth::id())->get();
        return response()->json($categories);
    }

    public function getBookmarks()
    {
        $bookmarks = Bookmark::with(['post', 'category'])
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($bookmarks);
    }

    public function destroy(Bookmark $bookmark)
    {
        if ($bookmark->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $bookmark->delete();
        return response()->json(['message' => 'Bookmark removed successfully']);
    }
} 