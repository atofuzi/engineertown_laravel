<!DOCTYPE html>
<html lang="ja">

@include('layouts.head')

    <!--ヘッダーメニュー-->
    <header>
        <div class="site-width">
            <div id="header-icon" class="icon-red"></div>
            <div id="header-icon" class="icon-orange"></div>
            <div id="header-icon" class="icon-green"></div>

            <h1><a href="/">Engineer Town</a></h1>
            
            <nav id="nav-top">
            　@yield('menu')
            </nav>
        </div>
    </header>

    <body>
        <!-- メインコンテンツ　-->
        <div id="contents" class="site-width">
            @section('main')
                <!--メイン-->
            @show
        </div>
          <!-- footer -->
        @include('layouts.footer')
    </body>
  </html>