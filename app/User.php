<?php

namespace App;

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
    //$user->microposts()->all() もしくは $user->micropostsで取得可能になる
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
    
    //これはマジックメソッドを使っているため
    //$micropost->user()->first() もしくは $micropost->user でユ－ザ－情報取れるらしい
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
}
