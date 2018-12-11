<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;  //added

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(10);
    
        return view('users.index',[
           'users' => $users,
        ]);
    }
    
    public function show($id)
   {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at','desc')->paginate(10);
       
        $data = [
            'user' => $user,
            'microposts' => $microposts,
            ];
        //dump($data); 
        //count_microposts をキーとするペアが $data に追加される
        //$hoge = array_merge($hoge,array('key2'=>'value2')); マージ()を使う例
        //$hoge = $hoge + array('key2'=>'value2');
        //$data = $data + $this->counts($user); これでも同じ意味になるかな？後で試す
        $data += $this->counts($user);
        //dump($data); 
        return view('users.show', $data);
   }
}