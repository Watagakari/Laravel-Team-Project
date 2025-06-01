<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post')
                    ->withTimestamps();
    }

    // Relasi untuk post yang disimpan user di kategori ini (library)
    public function libraryPosts()
    {
        return $this->hasMany(\App\Models\Library::class, 'category_id', 'id')->where('user_id', auth()->id());
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            // Detach posts but don't delete them
            $category->posts()->detach();
        });
    }
}
