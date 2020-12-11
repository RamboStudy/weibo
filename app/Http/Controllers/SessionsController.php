<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    //
    public function create(){
        return view('sessions.create');
    }

    //登录
    public function store(Request $request){
        $credentials = $this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required'
        ]);

        // 用户验证 该用户存在于数据库，且邮箱和密码相符合
        if (Auth::attempt($credentials)){
            //登录成功的相关操作
            session()->flash('success','欢迎回来！');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            //登录失败的相关操作
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

    }
    //退出
    public function destroy(){
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }

}
