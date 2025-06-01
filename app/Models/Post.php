<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body','user_id','location','cp','image_path'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'library_posts', 'post_id', 'user_id')
            ->withPivot('category_id')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function library()
    {
        return $this->hasMany(Library::class);
    }

    protected static function booted()
    {
        static::deleting(function ($post) {
            // Delete image if exists
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            
            // Detach from categories
            $post->categories()->detach();
            
            // Detach from users' libraries
            $post->savedByUsers()->detach();
        });
    }
}
