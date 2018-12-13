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
    
    public function followings()
    {
      // belongsToMany(１ 得られるModelクラス,
                  //  ２ 中間テーブル名,
      // ３ 中間テーブルに保存されている自分のidを示すカラム名'user_id',
      // ４ 中間テーブルに保存されている関係先のidを示すカラム名'follow_id')
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    //自分のフォロワーをかえしてくれるよ　
    public function followers()
    {
        //タイムスタンプを管理してくれるようになるよ
        //　リファ　もし中間テーブルのcreated_at、updated_atタイムスタンプを自動的に保守したい場合は、
        // withTimestampsメソッドをリレーション定義に付けてください。
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        //相手が自分じゃないかの確認
        $its_me = $this->id == ($userId);
        
        if($exist || $its_me){
            // 既にフォローしていれば何もしない
            return false;
        }else{
            //それ以外（未フォロー）であればフォローする
            //attach($userId);で中間テーブルにフォローの組み合わせのレコードを追加できる
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        //　相手が自分でないかの確認
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
            //既にフォローしていればフォローをはずす
            $this->followings()->detach($userId);
            return true;
        }else{
            //未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        //exists();はbool型で任意のレコードが存在しているかしていないかを返してくれる
        return $this->followings()->where('follow_id', $userId)->exists();
    }
}
