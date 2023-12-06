<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio',
        'image_profile',
        'image_bg',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }

    public function userAndFollowingPosts(User $user) {
        return Post::whereIn('user_id', function ($query) use ($user) {
            $query->select('user_id')
                ->from('follower_user')
                ->where('follower_id', $user->id)
                ->union(
                    User::select('id')
                        ->where('id', $user->id)
                        ->getQuery()
                );
        })
        ->with(['user', 'recipient']);
    }

    public function userAndRecipientPosts(User $user) {
        return Post::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('recipient_id', $user->id);
        })
        ->with(['user', 'recipient']);
    }

    public function followings(): BelongsToMany {
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id')->withTimestamps();
    }

    public function followers(): BelongsToMany {
        return $this->BelongsToMany(User::class, 'follower_user', 'user_id', 'follower_id')->withTimestamps();
    }

    public function likes(): BelongsToMany {
        return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
    }

    public function follows(User $user) {
        return $this->followings()->where('user_id', $user->id)->exists();
    }

    public function likesPost(Post $post) {
        return $this->likes()->where('post_id', $post->id)->exists();
    }

    public function friends() {
        return $this->followings()
            ->whereIn('user_id', $this->followers()->pluck('follower_id'));
    }

    public function getImageProfileURL() {
        if($this->image_profile) {
            return url('storage/'.$this->image_profile);
        }
        return "/userPP.jpg";
    }

    public function getImageBgURL() {
        if($this->image_bg) {
            return url('storage/'.$this->image_bg);
        }
        return "/windows_bg.jpeg";
    }

}
