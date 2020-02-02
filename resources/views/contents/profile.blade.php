@extends('layouts.base_contents',['title' => 'プロフィール'])
<!--ヘッダーメニュ-->
@section('menu')
    @if($u_id == $my_id)
        <ul>
            <li><a href="/outputList">掲示板</a></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
    @else
        <ul>
            <li><a href="/outputList">掲示板</a></li>
            <li><a href="/profile">マイページ</a></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
    @endif
@endsection

@section('main')
    <section class="profEdit-burner">
        <h2 class="profEdit-title">{{ $user->name }}</h2>
        <nav class="nav-prof">
            
        @if($u_id != $my_id)

            {{-- プロフィルが自分じゃない場合 --}}
            <form action="message.php" method="post">
                <a href="<?php echo 'message.php?u_id='.$u_id;?>"><div class="mail-icon"><i class="far fa-envelope"></i></div></a>
            </form>
            <div id="js-click-friend" class="friend-icon {{ $friend_flg ? 'active' : '' }}" aria-hidden="true" data-friend="{{ $u_id }}">
                {{ $friend_flg ? 'フレンド中' : 'フレンド登録' }}
            </div>
        
        @elseif($u_id == $my_id)
            
            {{-- プロフィルが自分の場合 --}}
             <a href="/profEdit">
                <div class="prof-icon">プロフィール変更</div>
            </a>

        @endif

        </nav>

        {{--DBにプロフィール画像が登録されていたら画像を表示--}}
        <!--プロフィール画像-->
        <div class="profEdit-img">
            <div class="img-style" style="opacity: 1; background-image: {{ $user->pic ? 'url('.$user->pic.');' : '' }}"></div>
        </div>
           
    </section>

    <!--　プロフィールテーブル -->
    <section class="prof-area">
        <table>
            <tr>
                <th align="left">プロフィール</th>
                <td>{{ $user->profile ?: $user->profile }}</td>
            <tr>
            <tr>
                <th align="left">学習開始時期</th>
                <td>@if(!empty($user->year)){{ $user->year.'年'.$user->month.'月' }} @endif</td>
            <tr>
            <tr>
                <th align="left">プログラミング歴</th>
                <td>@isset($user->engineer_history){{ $user->engineer_history.'年' }} @endisset</td>
            <tr>
            <tr>
                <th align="left">実務経験</th>
                <td>{{ $user->work_flg ? 'あり' : 'なし' }}</td>
            <tr>
            <tr>
                <th align="left">習得言語</th>
                <td>
                        @foreach($user->skill as $language => $value)
                            @if($user->skill[$language]==1)
                                <span>{{ Skills::get($language).' , ' }}</span>
                            @endif
                        @endforeach
                </td>
            <tr>
        </table>
    </section>

    
    @if($u_id == $my_id)

    {{--プロフィールが自分の場合に表示--}}
    <!--インフォメーションエリア-->
    <section id="info" class="info-area">
        <ul class="js-tab">
            <li v-on:click="change('1')" v-bind:class="{'active': isActive === '1'}">お知らせ</li>
            <li v-on:click="change('2')" v-bind:class="{'active': isActive === '2'}">メッセージ</li>
            <li v-on:click="change('3')" v-bind:class="{'active': isActive === '3'}">フレンド</li>
        </ul>

        <!-- タブ切替表示-->
        <div class="js-contents">
            <template v-if="isActive === '1' ">
            <!--タブ：お知らせ欄-->
            <div class="content">
                @if(!empty($info_top))
                    @foreach($info_top as $info)
                
                        <div>{{ $info->created_at }}</div>
                        <div>{{ $info->msg }}</div>

                    @endforeach

                @else
                    {{ 'お知らせはありません' }}
                @endif
            </div>

            </template>
            <template v-else-if="isActive === '2' ">
            <!--タブ：メッセージボード欄-->

            <div class="content" id="js-scroll-bottom">
                @foreach($info_msg as $key => $value)
                    <a href="<?php echo 'message.php?u_id='.$info_msg[$key]['id']; ?>">
                        <div class="info-msg-wrap">
                            <div class="info-msg-img" style="background-image: url({{ $info_msg[$key]['pic'] ? $info_msg[$key]['pic'].');' : 'storage/no_image.png);' }}"></div>
                            <div class="info-msg">
                                <!--メッセージ相手の名前-->
                                <h3>
                                    @if(!empty($info_msg[$key]['name']))
                                        {{ $info_msg[$key]['name'] }}
                                    @else
                                        {{ "no-name" }} 
                                    @endif
                                </h3>
                                <!--メッセージ-->
                                <p>
                                    @if(!empty($info_msg[$key]['msg']))
                                        {{ $info_msg[$key]['msg'] }}
                                    @else
                                        {{ "" }} 
                                    @endif
                                </p>
                            </div>
                            <!--投稿日-->
                            <p>
                            @if(!empty($info_msg[$key]['created_at']))
                                {{ $info_msg[$key]['created_at'] }}
                            @else
                                {{ "" }}
                            @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            </template>
            <template v-else-if="isActive === '3' ">
            <!--タブ：フレンドリスト欄-->

            <div class="content">
                    <div class="info-friend-list">
                    @foreach($info_friends as $friend)
                        <a href="<?php echo 'profDetail.php?u_id='.$friend->id; ?>">
                            <div class="info-friend-wrap">
                                <div class="info-friend-img" style="background-image: url({{ $friend->pic ? $friend->pic.');' : 'storage/no_image.png);' }}"></div>
                                <h3>{{ $friend->name ? $friend->name : 'no-name' }}</h3>
                            </div>
                        </a>
                    @endforeach
                    </div>
            </div>
            </template>
        </div>
    </section>
    
    @endif

    <!-- アウトプットリスト見出し-->
    <h2><i class="fas fa-list-ul" style="margin-right:5px;"></i> OUTPUT　List</h2>

    <!-- 検索 -->
    <form action="/profile/{{ $u_id }}" method="post" id="contents" enctype="multipart/form-data" class="wrap">
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
        <!--　listへ追加 -->
        @if($u_id === $my_id)

        {{--プロフィールが自分の場合、アウトプット追加のエリアを表示--}}
            <div>
                <a href="/outputRegist" class="list-input-area">
                    <i class="fas fa-folder" style="font-size:24px;"></i><span>Listへ追加+</span>
                </a>
            </div>
        @endif

        <!--　アウトプットをパネルで一覧表示 -->
        @if(!empty($outputs))
            @foreach($outputs as $key => $output)
                <div class="panel-list">
                    
                    @if($u_id !== $my_id)

                    {{--プロフィールが自分じゃない場合、パネル右上にユーザーimgを表示--}}
                        <a href="profDetail/{{$u_id}}">
                            <div class="user-img">
                                <img src="{{ $user->pic}}">
                            </div>
                        </a>

                    @else

                    {{--プロフィールが自分の場合、編集と削除メニューを表示--}}
                        <div class="menu-icon">
                            <i class="fas fa-bars js-menu-icon"></i>
                            <i class="fas fa-times js-menu-icon" style="display: none;"></i>
                            <nav style="display: none;">
                                <ul>
                                    <li><a href="outputEdit/{{ $output->id }}">編集</a></li>
                                    <li class="op-delete" aria-hidden="true" data-deleteid="{{ $output->id }}">削除</li>
                                </ul>
                            </nav>
                        </div>

                    @endif
                
                <div class="wrap">
                        <a href="{{ $u_id === $my_id ? '/outputEdit/'.$output->id : 'outputDetail/'.$output->id }}" class="panel">
                            <p class="panel-title">作品名 : {{ $output->name }}</p>
                            <div class="panel-img">
                                <img src="{{ $output->pic_main }}">
                            </div>
                            <div class="panel-comment">
                                <label>【アウトプット概要】
                                    <p>{{ $output->explanation }}</p>
                                </label>
                            </div>
                            <div class="panel-skills">
                                <label>【使用言語】
                                <p>
                                    @foreach($output->skill as $language => $value)
                                        @if($output->skill[$language]==1)
                                            {{ Skills::get($language).' , ' }}
                                        @endif
                                    @endforeach
                                </p>
                                </label>
                            </div>
                        </a>
                    <p class="post-date">投稿日： {{ $output->created_at }}</p>
                    <div class="like-icon-area">
                        <i class="fa fa-heart icn-like js-click-like {{ !$output->like ?: 'active' }}" aria-hidden="true" data-output="{{ $output->id }}">
                            <span class="js-like-count">
                            @if(!empty($output->like))
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