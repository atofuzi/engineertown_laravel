@extends('layouts.base_entry',['title' => 'ユーザー登録'])

@section('menu')
    <ul>
        <li><a href="login.php">掲示板</a></li>
        <li><a href="/login">ログイン</a></li>
    </ul>
@endsection

@section('main')
    <srction id="form">
                    <form method="POST" action="{{ route('register') }}" class="form">
                        @csrf
                        <div class="form-wrap" >
                            <!--ニックネーム入力-->
                            <div class="name-area">
                                @include('subview.err_msg',['err'=> 'name' ])
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="ニックネームを入力"  class="@error('name') err-input @enderror" required autocomplete="name" autofocus>
                            </div>
                            <!--email入力-->
                            <div class="mail-area">  
                                @include('subview.err_msg',['err'=> 'email' ])
                                <input type="text" name="email" value="{{ old('email') }}" placeholder="email" class="@error('email') err-input @enderror" required autocomplete="email">
                            </div>
                            <!--password入力-->
                            <div class="pass-area">
                                @include('subview.err_msg',['err'=> 'password' ])
                                <input type="password" id="password" name="password" placeholder="パスワード(6文字以上)" class="@error('password') err-input @enderror" required autcomplate="new-password">
                            </div>

                            <!--password入力(確認用)-->
                            <div class="pass-area">
                                @include('subview.err_msg',['err'=> 'password_confirmation' ])
                                <input type="password" id="password-confirm" name="password_confirmation" placeholder="パスワード(6文字以上)"class="@error('password_confirmaton') err-input @enderror" required autcomplate="new-password">
                            </div>


                            <div class="login-button">
                                <input type="submit" value="登録する">
                            </div>
                        </div>
                    </form>
    </section>
@endsection
