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
    @foreach($errors->all() as $key => $err)
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
        
        </section>
        <section class="form-container">
            <div class="profEdit-form">
                <!--　エラーメッセージ -->
                <p class="{{ !empty($errors->common) ?: 'err-msg'}}">{{ !empty($errors->common) ? $errors->common : '' }}</p>
                <div id="vue-input-text-1">
                    <label for="name">ニックネーム </label><br>
                    @include('subview.err_msg',['err' => 'name' ])
                    <input-text-component 
                        input-text="{{ old('name' , $user->name) }}"
                        input-Content="name"
                        placeholder=""
                    ></input-text-component>
                </div>
                <div id="vue-textarea">
                    <label for="profile">プロフィール</label><br>
                    @include('subview.err_msg',['err' => 'profile' ])
                    <textarea-component 
                        input-val="{{ old('profile' , $user->profile) }}"
                    ></textarea-component>
                </div>
            </div>
            <div class="skills">
                <p>・習得言語</p>
                <div id="vue-skills">
                    <skills-component 
                        :user-skills="{{ $user }}"
                        :old="{{ json_encode(Session::getOldInput()) }}"
                    ></skills-component>
                </div>
            </div>
            <div class="question">
                <div id="vue-input-text-2">
                    <p>・学習開始時期　※初学者のみ</p>
                    <label>
                    <input-text-component 
                        input-text="{{ old('year' , $user->year) }}"
                        input-Content="year"
                        placeholder="2019"
                    ></input-text-component>年</label>
                    <label>
                    <input-text-component 
                        input-text="{{ old('month' , $user->month) }}"
                        input-Content="month"
                        placeholder="1"
                    ></input-text-component>月</label>

                    <p>・エンジニア歴</p>
                    <label>
                    <input-text-component 
                        input-text="{{ old('engineer_history' , $user->engineer_history) }}"
                        input-Content="engineer_history"
                        placeholder="0"
                    ></input-text-component>年</label>
                </div>
                <div id="vue-radio">
                    <p>・実務経験</p>
                    <input type="hidden" name="work_flg" value=2>
                    <input-radio-component
                        radio-checked="{{ $user->work_flg }}"
                        old="{{ old('work_flg') }}"
                        id="work_flg"
                        :choices="['なし','あり']"
                    ></input-radio-component><br>
                </div>
            </div>
            
            <input type="submit" value="変更する"/>
        </section> 
</form>
@endsection