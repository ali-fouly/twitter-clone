<?php

namespace app;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    

    public function followers(){

        return $this->belongsToMany(User::class, 'user_followers', 'user_id', 'follower_id')->withTimestamps();
    }

    public function followings(){

        return $this->belongsToMany(User::class, 'user_followers', 'follower_id', 'user_id')->withTimestamps();
    }

    public function tweets(){

        return $this->hasMany(Tweet::class);
    }

    public function likes(){
        return $this->belongsToMany(Tweet::class, 'user_likes', 'user_id', 'tweet_id')->withTimestamps();
    }

    public function mentions(){
        return $this->belongsToMany(Tweet::class, 'user_mentions', 'mentioner_id', 'tweet_id')->withTimestamps();
    }

    public function mentioners(){
        return $this->belongsToMany(User::class, 'user_mentions', 'mentioner_id', 'user_id')->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
