<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    //追加
    protected $fillable = ['content','user_id'];
    //一対多の関係を記述　user()単数形という関数で
    //Micropost がどのユーザーに紐ついているのかを呼び足せるようにしておく
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //お気に入り機能の為の、多対多の関係をモデルに書いておく
        public function favarite_users()
    {
    //  引数1得たいクラス名　2中間テーブルを指定 3中間テーブルの自分のidを示すカラム名 4中間テーブルに記載されている関係先のidを示すカラム名
     return $this->belongsToMany(Micropost::class,'favarites' , 'micropost_id', 'user_id')->withTimestamps();   
    }
}
