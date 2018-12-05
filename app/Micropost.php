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
}
