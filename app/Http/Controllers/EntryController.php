<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Member;

class EntryController extends Controller
{
    public function userRegister(Request $req){
        $this->validate($req,Member::$rules);
        //DBに登録するpassをハッシュ化
        $req['pass'] = Hash::make($req->pass);

        //ログインタイムを記録
        $req['login_time'] = date('Y-m-d H:i:s');
    
        $d = new Member();

        $d->fill($req->except('_token','pass_re'))->save();
        $req->flash();
        return redirect('/signup');
    }
}
