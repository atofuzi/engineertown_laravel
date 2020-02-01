
@extends('layouts.base_contents',['title' => 'アウトプット登録'])

@section('menu')
    <ul>
        <li><a href="/outputList">掲示板</a></li>
        <li><a href="/profile">マイページ</a></li>
        <li><a href="/logout">ログアウト</a></li>
    </ul>
@endsection

@section('main')


<form action="/outputSave" method="post" enctype="multipart/form-data">
@csrf

        <h2 class="title">{{"アウトプット登録"}}</h2>
        <!--　エラーメッセージ -->
        @include('subview.err_msg',['err'=> 'common' ])
            <section class="output-regist">
                <div class="output-title">
                    <label>作品タイトル  <span style="color: #FF0000; padding-left: 10px;">※必須</span>
                        <!--エラーメッセージ表示エリア-->
                        @include('subview.err_msg',['err'=> 'op_name' ])
                        <!--作品タイトル入力蘭-->
                        <input type="text" name="op_name" class="op_name" value="{{ old('op_nam','') }}"><br>
                    </label>
                </div>

                <div class="output-explanation">
                    <label>説明
                    <!--エラーメッセージ表示エリア-->
                    @include('subview.err_msg',['err'=> 'explanation' ])
                      <!--作品説明入力蘭-->
                    <textarea name="explanation" id="js-count">{{ old('explanation') }}</textarea>
                    </label>
                    <p class="counter-text"><span class="js-count-view">@if(!empty(old('explanation'))) {{ mb_strlen(old('explanation')) }} @else {{ 0 }} @endif</span>/255文字</p>
                </div>

                <div class="pic-area" style="overflow: hidden;"> 

                    <!--メイン画像-->
                    <div class="pic-main">
                      <p>
                        【メイン画像】
                         <span style="color: #FF0000;">※必須</span>
                         @include('subview.err_msg',['err'=> 'pic_main' ])
                      </p>
                        <div class="area-drop-main js-area-drop">
                        <input type="file" name="pic_main" class="input-area js-file-input">
                        <img class="img-area js-file-prev" src="{{ old('pic_main','') }}">
                        ドラッグ&ドロップ
                        <i class="fas fa-times prev-close" style="display: none;"></i>
                        </div>
                    </div>
                    <!--サブ画像-->
                    
                    <div class="pic-sub"><p>【サブ画像①】 @include('subview.err_msg',['err'=> 'pic_sub1' ])</p>
                        <div class="area-drop-sub js-area-drop">
                        <input type="file" name="pic_sub1" class="input-area js-file-input" >
                        <img class="img-area js-file-prev" src="{{ old('pic_sub1','') }}">
                        ドラッグ&ドロップ
                        <i class="fas fa-times prev-close" style="display: none;"></i>
                        </div>
                    </div>
                      <!--サブ画像-->
                      <div class="pic-sub"><p>【サブ画像②】 @include('subview.err_msg',['err'=> 'pic_sub2' ]) </P>
                        <div class="area-drop-sub js-area-drop">
                            <input type="file" name="pic_sub2" class="input-area js-file-input">
                            <img class="img-area js-file-prev" src="{{ old('pic_sub2','') }}">
                            ドラッグ&ドロップ
                            <i class="fas fa-times prev-close" style="display: none;"></i>
                        </div>
                    </div>
                </div>

                    <!--動画エリア-->
                <div class="movie-area" style="float: left;"> 
                    <div class="movie">
                    <p>
                    【動画】(対応拡張子：mp4)
                    <!--エラーメッセージ表示エリア-->
                    @include('subview.err_msg',['err'=> 'movie' ])
                    </p>
                        <div class="area-drop-main js-area-drop">
                            <input type="file" name="movie" class="input-area js-file-input">
                            <video class="video-area js-file-prev" muted controls controlslist="nodownload" src="{{ old('movie','') }}"></video>
                                ドラッグ&ドロップ
                                <i class="fas fa-times prev-close" style="display: none;"></i>
                        </div>
                    </div>
                </div>

                <div class="skills-area" style="overflow: hidden;"> 
                    <div class="op-skills">
                        <p>・使用言語</p>
                        <input type="hidden" name="html_flg" value=0>
                        <label><input type="checkbox" name="html_flg" value=1 {{ old('html_flg') ? 'checked' : '' }}>HTML</label><br>

                        <input type="hidden" name="css_flg" value=0>
                        <label><input type="checkbox" name="css_flg" value=1 {{ old('css_flg') ? 'checked' : '' }}>CSS</label><br>

                        <input type="hidden" name="js_jq_flg" value=0>
                        <label><input type="checkbox" name="js_jq_flg" value=1 {{ old('js_jq_flg') ? 'checked' : '' }}>javascript・jquery</label><br>

                        <input type="hidden" name="sql_flg" value=0>
                        <label><input type="checkbox" name="sql_flg" value=1 {{ old('sql_flg') ? 'checked' : '' }}>SQL</label><br>

                        <input type="hidden" name="java_flg" value=0>
                        <label><input type="checkbox" name="java_flg" value=1 {{ old('java_flg') ? 'checked' : '' }}>JAVA</label><br>

                        <input type="hidden" name="php_flg" value=0>
                        <label><input type="checkbox" name="php_flg" value=1 {{ old('php_flg') ? 'checked' : '' }}>PHP</label><br>

                        <input type="hidden" name="php_oj_flg" value=0>
                        <label><input type="checkbox" name="php_oj_flg" value=1 {{ old('php_oj_flg') ? 'checked' : '' }}>PHP（オブジェクト指向)</label><br>

                        <input type="hidden" name="php_fw_flg" value=0>
                        <label><input type="checkbox" name="php_fw_flg" value=1 {{ old('php_fw_flg') ? 'checked' : '' }}>PHP（フレームワーク）</label><br>

                        <input type="hidden" name="ruby_flg" value=0>
                        <label><input type="checkbox" name="ruby_flg" value=1 {{ old('ruby_flg') ? 'checked' : '' }}>ruby</label><br>

                        <input type="hidden" name="rails_flg" value=0>
                        <label><input type="checkbox" name="rails_flg" value=1 {{ old('rails_flg') ? 'checked' : '' }}>rails</label><br>

                        <input type="hidden" name="laravel_flg" value=0>
                        <label><input type="checkbox" name="laravel_flg" value=1 {{ old('laravel_flg') ? 'checked' : '' }}>laravel</label><br>

                        <input type="hidden" name="swift_flg" value=0>
                        <label><input type="checkbox" name="swift_flg" value=1 {{ old('swift_flg') ? 'checked' : '' }}>swift</label><br>

                        <input type="hidden" name="scala_flg" value=0>
                        <label><input type="checkbox" name="scala_flg" value=1 {{ old('scala_flg') ? 'checked' : '' }}>scala</label><br>

                        <input type="hidden" name="go_flg" value=0>
                        <label><input type="checkbox" name="go_flg" value=1 {{ old('go_flg') ? 'checked' : '' }}>go</label><br>

                        <input type="hidden" name="kotolin_flg" value=0>
                        <label><input type="checkbox" name="kotolin_flg" value=1 {{ old('kotolin_flg') ? 'checked' : '' }}>kotolin</label><br>
                    </div>
                  
                </div>
                <input type="submit" value="登録する">
            </section> 
    </form>


@endsection