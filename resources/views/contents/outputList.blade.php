@extends('layouts.base_contents',['title' => 'アウトプットリスト'])

@section('menu')
    <ul>
        <li><a href="/profile">マイページ</a></li>
        <li><a href="/logout">ログアウト</a></li>
    </ul>
@endsection

@section('main')
<!-- アウトプットリスト見出し-->
<h2><i class="fas fa-list-ul" style="margin-right:5px;"></i> OUTPUT　List</h2>

<!-- 検索 -->
<form action="/outputList" method="post" id="contents" enctype="multipart/form-data" class="wrap">
    @csrf
    <div class='keyword-search-area'>
        <input type="search" name="keyword" placeholder="キーワードを入力" class="keyword" value="{{ old('keyword','') }}">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
    <!--ポップアップ検索機能-->
    <div class="filtered-search">条件検索 <i class="fas fa-caret-down"  style="color: #FFF; margin-left: 5px;"></i></div>
        <div class="popup">
            <div class="filtered-search-panel">
                <p>ー使用している言語ー</p>
                <i class="fas fa-times icon-batu" id="close"></i>
                <table class="filtered-search-table">
                    <tr>
                        <td>
                            <input type="hidden" name="html_flg" value="">
                            <label><input type="checkbox" name="html_flg" value=1 {{ old("html_flg") == 1 ? 'checked="checked"' : '' }}>HTML</label>
                        </td>
                        <td>
                            <input type="hidden" name="css_flg" value="">
                            <label><input type="checkbox" name="css_flg" value=1 {{ old("css_flg") == 1 ? 'checked="checked"' : '' }}>CSS</label>
                        </td>
                        <td>
                            <input type="hidden" name="js_jq_flg" value="">
                            <label><input type="checkbox" name="js_jq_flg" value=1 {{ old("js_jq_flg") == 1 ? 'checked="checked"' : '' }}>javascript・jquery</label>
                        </td>
                        <td>
                            <input type="hidden" name="sql_flg" value="">
                            <label><input type="checkbox" name="sql_flg" value=1 {{ old("sql_flg") == 1 ? 'checked="checked"' : '' }}>SQL</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="java_flg" value="">
                            <label><input type="checkbox" name="java_flg" value=1 {{ old("java_flg") == 1 ? 'checked="checked"' : '' }}>JAVA</label>
                        </td>
                        <td>
                            <input type="hidden" name="php_flg" value="">
                            <label><input type="checkbox" name="php_flg" value=1 {{ old("php_flg") == 1 ? 'checked="checked"' : '' }}>PHP</label>
                        </td>
                        <td>
                            <input type="hidden" name="php_oj_flg" value="">
                            <label><input type="checkbox" name="php_oj_flg" value=1 {{ old("php_oj_flg") == 1 ? 'checked="checked"' : '' }}>PHP（オブジェクト指向)</label>
                        </td>
                        <td>
                            <input type="hidden" name="php_fw_flg" value="">
                            <label><input type="checkbox" name="php_fw_flg" value=1 {{ old("php_fw_flg") == 1 ? 'checked="checked"' : '' }}>PHP（フレームワーク）</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="ruby_flg" value="">
                            <label><input type="checkbox" name="ruby_flg" value=1 {{ old("ruby_flg") == 1 ? 'checked="checked"' : '' }}>ruby</label>
                        </td>
                        <td>
                            <input type="hidden" name="rails_flg" value="">
                            <label><input type="checkbox" name="rails_flg" value=1 {{ old("rails_flg") == 1 ? 'checked="checked"' : '' }}>rails</label>
                        </td>
                        <td>
                            <input type="hidden" name="laravel_flg" value="">
                            <label><input type="checkbox" name="laravel_flg" value=1 {{ old("laravel_flg") == 1 ? 'checked="checked"' : '' }}>laravel</label>
                        </td>
                        <td>
                            <input type="hidden" name="swift_flg" value="">
                            <label><input type="checkbox" name="swift_flg" value=1 {{ old("swift_flg") == 1 ? 'checked="checked"' : '' }}>swift</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="scala_flg" value="">
                            <label><input type="checkbox" name="scala_flg" value=1 {{ old("scala_flg") == 1 ? 'checked="checked"' : '' }}>scala</label>
                        </td>
                        <td>
                            <input type="hidden" name="go_flg" value="">
                            <label><input type="checkbox" name="go_flg" value=1 {{ old("go_flg") == 1 ? 'checked="checked"' : '' }}>go</label>
                        </td>
                        <td>
                            <input type="hidden" name="kotolin_flg" value="">
                            <label><input type="checkbox" name="kotolin_flg" value=1 {{ old("kotolin_flg") == 1 ? 'checked="checked"' : '' }}>kotolin</label>
                        </td>
                    </tr>
                </table>
                <span id="clear">条件クリア</span>
                <input type="submit" value="検索">
            </div>
        </div>
    
</form>

<!--アウトプット一覧-->
<section class="output-list">

    <!--　アウトプットをパネルで一覧表示 -->
    @if( !empty( $outputs ) )
        @foreach( $outputs as $output )
            <div class="panel-list">

                    <a href="profile/{{ $output->user_id }}">
                        <div class="user-img">
                            <img src="{{ asset( $output->pic_user ) }}">
                        </div>
                    </a>
            
            <div class="wrap">
                    <a href="outputDetail/{{ $output->user_id }}" class="panel">
                        <p class="panel-title">作品名 : {{ $output->name }}</p>
                        <div class="panel-img">
                            <img src="{{ asset( $output->pic_main ) }}">
                        </div>
                        <div class="panel-comment">
                            <label>【アウトプット概要】
                                <p>{{ $output->explanation }}</p>
                            </label>
                        </div>
                        <div class="panel-skills">
                            <label>【使用言語】
                            <p>
                                @foreach($output->skill as $language => $flg)
                                    @if( $output->skill[$language] == 1 )
                                        {{ Skills::get($language).' , ' }}
                                    @endif
                                @endforeach
                            </p>
                            </label>
                        </div>
                    </a>
                <p class="post-date">投稿日： {{ $output->created_at }}</p>
                <div class="like-icon-area">
                    <i class="fa fa-heart icn-like js-click-like {{ empty($output->like) ?: 'active' }}" aria-hidden="true" data-output="{{ $output->id }}">
                        <span class="js-like-count">
                        @if(!empty($output->like) )
                            {{ $output->like }}
                        @else
                            {{ "" }}
                        @endif    
                    </span>
                    </i>
                </div>
            </div>
        </div>

        @endforeach
    @endif
</section>

@endsection