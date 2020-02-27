<?php $__env->startSection('menu'); ?>
    <ul>
        <li><a href="outputList.php">掲示板</a></li>
        <li><a href="/register">ユーザー登録</a></li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
    <section id="form">
        <form action="<?php echo e(route('login')); ?>" method="post" class="form">
        <?php echo csrf_field(); ?>
            <div class="form-wrap" >
                <div class="mail-area">
                    <?php echo $__env->make('subview.err_msg',['err' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <input id="email" type="text" name="email" placeholder="email" class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-input <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required autocomplate="email" autofocus>
                </div>
                <div class="pass-area">
                    <?php echo $__env->make('subview.err_msg',['err' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <input id="password" type="password" name="password" placeholder="パスワード" class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-input <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" reqired autocomplate="current-password"><br>
                </div>
                <div class="text-area">

                    <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>><label for="remember">次回ログインを省略する</label><br>
                    
                    <?php if(Route::has('password.request')): ?>
                        <p>パスワードを忘れた方は<a href="<?php echo e(route('password.request')); ?>">こちら<a></p>
                    <?php endif; ?>
                </div>
                <div class="login-button">
                <input type="submit" value="ログイン"><br>
                </div>
            </div>
        </form>
    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base_entry',['title' => 'ログイン'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/entry/login.blade.php ENDPATH**/ ?>