<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index()
    {
        $data =[];
        if(\Auth::check()){
            $user = \Auth::user();
            // User はmicroposts()メソッドでhasmanyなmicropostsを取得できる
            //feed_microposts()で自分+フォローしている人のmicropostsを取得できる
            $microposts = $user->feed_microposts()->orderBy('created_at','desc')->paginate(10);
           
            $data = [
                'user' => $user,
                'microposts' => $microposts,
                ];
        }
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);
//$requestオブジェクトに入っているmicropostsのuser()メソッドでどのユーザーかが返り、ユーザーに紐ついているmicropostsが返ってくるので新規投稿ができる
        $request->user()->microposts()->create([
            'content' =>$request->content,
        ]);
        //投稿完了後に直前のページが表示されるようになる
        return back();
    }
    
    public function destroy($id)
    {
         $micropost = \App\Micropost::find($id);
    //ログイン中の人とmicropostsの所有者が同じだったら
         if(\Auth::id() ===$micropost->user_id) {
             $micropost->delete();
         }

         return back();
    } 
    
    public function show($id)
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at','desc')->pagenate(10);

        $data = [
          'user' => $user,
          'microposts' => $microposts,
        ];
        
        $data += $this->counts($user);
        
        return view('user.show', $data);
        
    }
}
