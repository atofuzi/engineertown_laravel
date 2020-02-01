@extends('layouts.base_entry',['title' => 'ログイン'])

@section('menu')
    <ul>
        <li><a href="outputList.php">掲示板</a></li>
        <li><a href="/signup">ユーザー登録</a></li>
    </ul>
@endsection

@section('main')
    <section id="form">
        <form action="{{ route('login') }}" method="post" class="form">
        @csrf
            <div class="form-wrap" >
                <div class="mail-area">
                    @include('subview.err_msg',['err' => 'email'])
                    <input id="email" type="text" name="email" placeholder="email" class="@error('email') err-input @enderror" value="{{ old('email') }}" required autocomplate="email" autofocus>
                </div>
                <div class="pass-area">
                    @include('subview.err_msg',['err' => 'email'])
                    <input id="password" type="password" name="password" placeholder="パスワード" class="@error('password') err-input @enderror" reqired autocomplate="current-password"><br>
                </div>
                <div class="text-area">

                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><label for="remember">次回ログインを省略する</label><br>
                    
                    @if (Route::has('password.request'))
                        <p>パスワードを忘れた方は<a href="{{ route('password.request') }}">こちら<a></p>
                    @endif
                </div>
                <div class="login-button">
                <input type="submit" value="ログイン"><br>
                </div>
            </div>
        </form>
    </section>

@endsection