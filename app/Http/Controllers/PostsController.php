<?php

namespace App\Http\Controllers;

use App\Post;
use Auth;
use Validator;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    // コンストラクタ　このクラスが呼ばれると以下が処理される
    // newアクション、storeアクションを実行するとサインインページにリダイレクトする
    public function __construct()
    {
        // ログインしているかどうか
        $this->middleware('auth');
    }
    
    public function index()
    {
        // limitメソッドレコードの上限
        $posts = Post::limit(10)
            // orderByはレコードを特定の順序で並べる。created_atの降順
            ->orderBy('created_at','desc')
            ->get();
        // post/index.blade.phpを表示
        return view('post/index',['posts' => $posts]);
    }
    
    public function new()
    {
        // post/new.blade.phpを表示
        return view('post/new');
    }
    
    public function store(Request $request)
    {
        // バリデーション　入力した値のチェック
        // caption と photo の入力は必須。　cationは255文字以内。
        $validator = Validator::make($request->all() , ['caption' =>'required|max:255', 'photo' => 'required']);
        
        // エラーの場合
        if($validator->fails())
        {
            // 入力値の値を保持したまま、前の画面に戻る
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        // ポストモデルを作成
        // 入力したデータを元に$postオブジェクトを組み立てる
        $post = new Post;
        $post->caption = $request->caption;
        $post->user_id = Auth::user()->id;
        
        $post->image = base64_encode(file_get_contents($request->photo));
        
        $post->save();
        
        // $request->photo->storeAs('public/post_images', $post->id . '.jpg');
        
        return redirect('/');
    }
    public function destroy($post_id)
    {
        $post = Post::find($post_id);
        $post->delete();
        return redirect('/');
    }
    
}
