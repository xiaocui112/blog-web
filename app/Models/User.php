<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Notifications\TopicReplied;
use Illuminate\Support\Facades\Auth;
use App\Models\Traits\ActiveUserHelper;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable;
    use ActiveUserHelper;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'introduction', 'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getAvatarAttribute($value)
    {
        return env("APP_URL") . '/' . 'storage/' . $value;
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function overNotify(TopicReplied $instance)
    {
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->notify($instance);
    }
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
