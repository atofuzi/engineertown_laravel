
@extends('layouts.base_contents',['title' => 'プロフィール編集'])
<!--ヘッダーメニュ-->
@section('menu')
        <ul>
            <li><a href="/board">掲示板</a></li>
            <li><a href="/profile">マイページ</a></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
@endsection

@section('main')
@if(count($errors) > 0)
    <ul>
    @foreach($errors->all() as $err)
        <li class="err-msg">{{ $err }}</li>
    @endforeach
    </ul>
@endif

<form action="" method="post" enctype="multipart/form-data">
@csrf
            <section class="profEdit-burner">
        
                <h2 class="profEdit-title">プロフィール編集</h2>

                <!--プロフィール画像登録-->
                <!--DBにプロフィール画像が登録されていたら背景色を黒にする-->
                <div class="profEdit-img" style="{{ empty($user->pic) ?: 'background: #000;' }}">
                <!--DBにプロフィール画像が登録されていたら画像を表示-->
                <div class="img-style js-prof-img" style="background-image: {{ $user->pic ? 'url('.$user->pic.');' : '' }}">
                    <!--カメラアイコン-->
                    <i class="fas fa-camera-retro icon-camera"></i>
                     <div class="js-wrap-input">
                        <input type="file" name="pic" class="input-area js-file-input">
                    </div>
                </div>
                </div>
                    <label class="{{ !empty($errors->pic) ?: 'err-msg'}}">{{ !empty($errors->pic) ? $errors->pic : '' }}</label>
               
            </section>
            <section class="form-container">
                <div class="profEdit-form">
                    <!--　エラーメッセージ -->
                    <p class="{{ !empty($errors->common) ?: 'err-msg'}}">{{ !empty($errors->common) ? $errors->common : '' }}</p>

                    <label>ニックネーム<br>
                        <input type="text" name="name" class="name" value="{{ old('name', $user->name) }}"><br>
                    </label>
                    <div class="profile-area">
                    <label>自己紹介文
                    @include('subview.err_msg',['err'=> 'profile' ])
                    <textarea name="profile" id="js-count">{{ old('profile', $user->profile) }}</textarea>
                    </label>
                    <p class="counter-text"><span class="js-count-view">@if(!empty(old('profile')) || !empty($user->profile)) {{ mb_strlen( old('profile',$user->profile) ) }} @else{{ 0 }} @endif</span>/255文字</p>
                    </div>
                <section class="skills">
                        <p>・習得言語</p>

                        <input type="hidden" name="html_flg" value=0>
                        <label><input type="checkbox" name="html_flg" value=1 <?php if(old('html_flg') == 1 || $user->html_flg ==1){ echo 'checked="checked"'; } ?>>HTML</label><br>

                        <input type="hidden" name="css_flg" value=0>
                        <label><input type="checkbox" name="css_flg" value=1 <?php if(old('css_flg') == 1 || $user->css_flg ==1){ echo 'checked="checked"'; } ?>>CSS</label><br>

                        <input type="hidden" name="js_jq_flg" value=0>
                        <label><input type="checkbox" name="js_jq_flg" value=1 <?php if(old('js_jq_flg') == 1 || $user->js_jq_flg ==1){ echo 'checked="checked"'; } ?>>javascript・jquery</label><br>

                        <input type="hidden" name="sql_flg" value=0>
                        <label><input type="checkbox" name="sql_flg" value=1 <?php if(old('sql_flg') == 1 || $user->sql_flg ==1){ echo 'checked="checked"'; } ?>>SQL</label><br>

                        <input type="hidden" name="java_flg" value=0>
                        <label><input type="checkbox" name="java_flg" value=1 <?php if(old('java_flg') == 1 || $user->java_flg ==1){ echo 'checked="checked"'; } ?>>JAVA</label><br>

                        <input type="hidden" name="php_flg" value=0>
                        <label><input type="checkbox" name="php_flg" value=1 <?php if(old('php_flg') == 1 || $user->php_flg ==1){ echo 'checked="checked"'; } ?>>PHP</label><br>

                        <input type="hidden" name="php_oj_flg" value=0>
                        <label><input type="checkbox" name="php_oj_flg" value=1 <?php if(old('php_oj_flg') == 1 || $user->php_oj_flg ==1){ echo 'checked="checked"'; } ?>>PHP（オブジェクト指向)</label><br>

                        <input type="hidden" name="php_fw_flg" value=0>
                        <label><input type="checkbox" name="php_fw_flg" value=1 <?php if(old('php_fw_flg') == 1 || $user->php_fw_flg ==1){ echo 'checked="checked"'; } ?>>PHP（フレームワーク）</label><br>

                        <input type="hidden" name="ruby_flg" value=0>
                        <label><input type="checkbox" name="ruby_flg" value=1 <?php if(old('ruby_flg') == 1 || $user->ruby_flg ==1){ echo 'checked="checked"'; } ?>>ruby</label><br>

                        <input type="hidden" name="rails_flg" value=0>
                        <label><input type="checkbox" name="rails_flg" value=1 <?php if(old('rails_flg') == 1 || $user->rails_flg ==1){ echo 'checked="checked"'; } ?>>rails</label><br>

                        <input type="hidden" name="laravel_flg" value=0>
                        <label><input type="checkbox" name="laravel_flg" value=1 <?php if(old('laravel_flg') == 1 || $user->laravel_flg ==1){ echo 'checked="checked"'; } ?>>laravel</label><br>

                        <input type="hidden" name="swift_flg" value=0>
                        <label><input type="checkbox" name="swift_flg" value=1 <?php if(old('swift_flg') == 1 || $user->swift_flg ==1){ echo 'checked="checked"'; } ?>>swift</label><br>

                        <input type="hidden" name="scala_flg" value=0>
                        <label><input type="checkbox" name="scala_flg" value=1 <?php if(old('scala_flg') == 1 || $user->scala_flg ==1){ echo 'checked="checked"'; } ?>>scala</label><br>

                        <input type="hidden" name="go_flg" value=0>
                        <label><input type="checkbox" name="go_flg" value=1 <?php if(old('go_flg') == 1 || $user->go_flg ==1){ echo 'checked="checked"'; } ?>>go</label><br>

                        <input type="hidden" name="kotolin_flg" value=0>
                        <label><input type="checkbox" name="kotolin_flg" value=1 <?php if(old('kotolin_flg') == 1 || $user->kotolin_flg ==1){ echo 'checked="checked"'; } ?>>kotolin</label><br>
                </section>
                <section class="question">
                        <p>・学習開始時期　※初学者のみ</p>
                        <label><input type="text" name="year" value="{{ old('year', $user->year) }}" placeholder="2019">年</label>
                        <label><input type="text" name="month" value="{{ old('month', $user->month) }}" placeholder="1">月</label>
                        <p>・エンジニア歴</p>
                        <label><input type="text" name="engineer_history" value="{{ old('month', $user->engineer_history) }}">年</label>
                        <p>・実務経験</p>
                        <input type="hidden" name="work_flg" value=2>
                        <label><input type="radio" name="work_flg" value=0 <?php if(old('work_flg') == 0 || $user->work_flg ==0){ echo 'checked="checked"'; } ?>>なし</label>
                        <label><input type="radio" name="work_flg" value=1 <?php if(old('work_flg') == 1 || $user->work_flg ==1){ echo 'checked="checked"'; } ?>>あり</label><br>
                </section>
                <input type="submit" value="変更する">
                </div>
            </section> 
</form>
@endsection