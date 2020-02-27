<!DOCTYPE html>
<html lang="ja">

<!--ヘッダー読み込み-->
<?php echo $__env->make('layouts.head',['title' => 'engineertown'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body class="background">
    <div class="site-width">
        <main class="top-page-content">
            <h2 class="top-page-title js-top-page-title" style="display: none;">Engineer Town</h2>
            <div  class="menu-list js-menu-list" style="display: none;">
                <a href="/outputList"><div class="top-page-menu"><span>enter</span></div></a>
                <a href="/login"><div class="top-page-menu"><span>login</span></div></a>
                <a href="/register"><div class="top-page-menu"><span>ユーザー登録</span></div></a>
            </div>  
        </main>
    </div>
</body>
<!--フッターの読み込み-->
<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</html><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/entry/index.blade.php ENDPATH**/ ?>