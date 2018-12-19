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
        'users' => $users
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
   
   public function followings($id)
   {
       $user = User::find($id);
       $followings = $user->followings()->paginate(10);
       
       $data = [
           'user' => $user,
           'users' => $followings,
           ];
       $data += $this->counts($user);
       
       return view('users.followings', $data);
       
    //   $dataには$count_microposts,$count_followings, $count_followers,
   }
   
   public function followers($id)
   {
       $user = User::find($id);
       $followers = $user->followers()->paginate(10);
       
       $data = [
           'user' => $user,
           'users' => $followers,
        ];
 
         // counts()で取得する中身
         // 'count_microposts' => $count_microposts,
         // 'count_followings' => $count_followings,
         // 'count_followers' => $count_followers,
        
        $data += $this->counts($user);
        
        return view('users.followers', $data);
   }
   
   public function favorites($id)
   {
        $user = User::find($id);
   
        $favorites = $user->feed_favorites()->paginate(10);

        $data = [
            'user' => $user,
            'favorites' => $favorites,
            ];    
        $data += $this->counts($user);
   
       return view('users.favorites', $data);
   }
}
