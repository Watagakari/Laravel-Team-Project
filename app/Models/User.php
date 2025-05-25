<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userPosts(){
        return $this->hasMany(Post::class,'user_id');
    }

    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'library_posts', 'user_id', 'post_id')->withTimestamps();
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            // Hapus semua gambar dan detach relasi sebelum delete post
            foreach ($user->userPosts as $post) {
                // Hapus relasi di tabel pivot
                $post->savedByUsers()->detach();

                // Hapus gambar jika ada
                if ($post->image_path) {
                    Storage::disk('public')->delete($post->image_path);
                }

                // Hapus post
                $post->delete();
            }

            // Hapus semua library yang disimpan user ini
            $user->savedPosts()->detach();
        });
    }
}
