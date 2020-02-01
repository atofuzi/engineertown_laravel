<!DOCTYPE html>
<html lang="ja">

<!--ヘッダー読み込み-->
@include('layouts.head',['title' => 'engineertown'])

<body class="background">
    <div class="site-width">
        <main class="top-page-content">
            <h2 class="top-page-title js-top-page-title" style="display: none;">Engineer Town</h2>
            <div  class="menu-list js-menu-list" style="display: none;">
                <a href="outputList.php"><div class="top-page-menu"><span>enter</span></div></a>
                <a href="/login"><div class="top-page-menu"><span>login</span></div></a>
                <a href="/register"><div class="top-page-menu"><span>ユーザー登録</span></div></a>
            </div>  
        </main>
    </div>
</body>
<!--フッターの読み込み-->
@include('layouts.footer')

</html>