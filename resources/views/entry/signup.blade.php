@extends('layouts.base_entry',['title' => 'ユーザー登録'])

@section('menu')

    <ul>
        <li><a href="login.php">掲示板</a></li>
        <li><a href="/login">ログイン</a></li>
    </ul>
@endsection

@section('main')
    <section id="form">
        <form action="/userRegister" method="post" class="form">
        @csrf
            <div class="form-wrap" >
                <div class="name-area">
                @include('subview.err_msg',['err'=> 'name' ])
                <input type="text" name="name" value="{{ old('name') }}" placeholder="ニックネームを入力"  class="first-input <?php if(!empty($err_msg['name'])) echo "err-input"?>" style="<?php if(!empty($err_msg['name'])) echo "margin-top:0px;"?>">
                </div> 
                <div class="mail-area">  
                @include('subview.err_msg',['err'=> 'email' ])
                <input type="text" name="email" value="{{ old('email') }}" placeholder="email" class="<?php if(!empty($err_msg['email'])) echo "err-input"?>">
                </div>
                <div class="pass-area">
                @include('subview.err_msg',['err'=> 'pass' ])
                <input type="password" name="pass" value="{{ old('pass') }}" placeholder="パスワード(6文字以上)"class="<?php if(!empty($err_msg['pass'])) echo "err-input"?>" >
                </div>
                <div class="pass-area">
                @include('subview.err_msg',['err'=> 'pass_re' ])
                <input type="password" name="pass_re" value="{{ old('pass_re') }}" placeholder="パスワード(確認用)" class="<?php if(!empty($err_msg['pass'])) echo "err-input"?>">
                </div>                        
                <div class="login-button">
                <input type="submit" value="登録する">
                </div>
            </div>
        </form>
    </section>
@endsection