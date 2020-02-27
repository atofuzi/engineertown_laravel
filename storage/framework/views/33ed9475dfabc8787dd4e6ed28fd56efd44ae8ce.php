<!DOCTYPE html>
<html lang="ja">

<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--ヘッダーメニュー-->
    <header>
        <div class="site-width">
            <div id="header-icon" class="icon-red"></div>
            <div id="header-icon" class="icon-orange"></div>
            <div id="header-icon" class="icon-green"></div>

            <h1><a href="/">Engineer Town</a></h1>
            
            <nav id="nav-top">
            　<?php echo $__env->yieldContent('menu'); ?>
            </nav>
        </div>
    </header>

    <body>
        <!-- メインコンテンツ　-->
        <div id="contents" class="site-width">
            <?php $__env->startSection('main'); ?>
                <!--メイン-->
            <?php echo $__env->yieldSection(); ?>
        </div>
          <!-- footer -->
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
  </html><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/layouts/base_contents.blade.php ENDPATH**/ ?>