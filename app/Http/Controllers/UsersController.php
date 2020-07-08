<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Validator;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // コンストラクタ　このクラスが呼ばれる最初に以下の処理を行う
    public function __construct(){
        // ログインしてるかどうか
        $this->middleware('auth');
    }
    
    public function show($user_id)
    {
        $user = User::where('id',$user_id)
        // 最初のレコードだけを返します。
            ->firstOrFail();
            
        return view('user/show',['user' =>$user]);
    }
    public function edit(){
        $user = Auth::user();
        
        // 編集画面を表示
        return view('user/edit', ['user' => $user]);
    }
    public function update(Request $request){
        // 入力した値（$requestのデータ）をチェック
        $validator = Validator::make($request->all() , [
            'user_name' => 'required|string|max:255',
            'user_password' => 'required|string|min:6|confirmed',
            ]);
        //バリデーションの結果がエラーの場合 
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $user = User::find($request->id);
        $user->name = $request->user_name;
        // if ($request->user_profile_photo !=null) {
        //     // storeAsメソッド 写真をサーバに保存　user_id+.jpg
        //     $request->user_profile_photo->storeAs('public/user_images', $user->id . '.jpg');
        //     $user->profile_photo = $user->id . '.jpg';
        // }
        
        $user->password = bcrypt($request->user_password);
        
        if ($request->user_profile_photo !=null){
            $user->image = base64_encode(file_get_contents($request->user_profile_photo));
        }
        
        
        // saveメソッド　$userのデータベースを保存
        $user->save();
        
        // redirectメソッド　アカウントのアップデート後、プロフィールページに遷移
        return redirect('/users/'.$request->id);
    }
    
    
}
