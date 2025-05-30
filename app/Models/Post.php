<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body','user_id','location','cp','image_path'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'library_posts', 'post_id', 'user_id')->withTimestamps();
    }

}
