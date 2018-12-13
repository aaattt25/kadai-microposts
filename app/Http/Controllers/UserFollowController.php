<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
    
{
    //フォローできるようにするstore処理
    public function store(Request $request,$id)
    {
        
        \Auth::user()->follow($id);
        return back();
    }
    
    //フォローをやめるようにするdestroyアクション
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back;
    }
}
