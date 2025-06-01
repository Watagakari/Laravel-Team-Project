<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Auth::user()->categories()->with('posts')->get();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $categories
                ]);
            }
            
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error loading categories: ' . $e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load categories',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to load categories');
        }
    }

    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Please login first.'
                ], 401);
            }

            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . Auth::id()
            ]);

            $category = Auth::user()->categories()->create([
                'name' => $request->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first('name'),
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Category $category)
    {
        try {
            // Ensure user owns the category
            if ($category->user_id !== Auth::id()) {
                abort(403);
            }

            $category->load('posts');
            return view('categories.show', compact('category'));
        } catch (\Exception $e) {
            Log::error('Error showing category: ' . $e->getMessage());
            return back()->with('error', 'Failed to load category');
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            // Ensure user owns the category
            if ($category->user_id !== Auth::id()) {
                abort(403);
            }

            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id . ',id,user_id,' . Auth::id()
            ]);

            $category->update([
                'name' => $request->name
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'category' => $category,
                    'message' => 'Category updated successfully'
                ]);
            }

            return redirect()->route('categories.index')
                           ->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update category',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to update category');
        }
    }

    public function destroy(Category $category)
    {
        try {
            // Ensure user owns the category
            if ($category->user_id !== Auth::id()) {
                abort(403);
            }

            $category->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category deleted successfully'
                ]);
            }

            return redirect()->route('categories.index')
                           ->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete category',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to delete category');
        }
    }
}
