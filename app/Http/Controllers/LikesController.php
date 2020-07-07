<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Auth;
use Validator;

use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        // newキーワードを使ってlikeインスタンスを作成
        $like = new Like;
        // いいねを押した投稿のidが入る
        $like->post_id = $request->post_id;
        // ログインのidが入る
        $like->user_id = Auth::user()->id;
        $like->save();
        
        return redirect('/');
    }
    public function destroy(Request $request)
    {
        $like = Like::find($request->like_id);
        $like->delete();
        return redirect('/');
    }
}
