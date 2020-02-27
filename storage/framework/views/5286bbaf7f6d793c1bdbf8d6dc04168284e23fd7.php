<?php $__env->startSection('menu'); ?>
    <ul>
        <li><a href="login.php">掲示板</a></li>
        <li><a href="/login">ログイン</a></li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
    <srction id="form">
                    <form method="POST" action="<?php echo e(route('register')); ?>" class="form">
                        <?php echo csrf_field(); ?>
                        <div class="form-wrap" >
                            <!--ニックネーム入力-->
                            <div class="name-area">
                                <?php echo $__env->make('subview.err_msg',['err'=> 'name' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="ニックネームを入力"  class="<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-input <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required autocomplete="name" autofocus>
                            </div>
                            <!--email入力-->
                            <div class="mail-area">  
                                <?php echo $__env->make('subview.err_msg',['err'=> 'email' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <input type="text" name="email" value="<?php echo e(old('email')); ?>" placeholder="email" class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-input <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required autocomplete="email">
                            </div>
                            <!--password入力-->
                            <div class="pass-area">
                                <?php echo $__env->make('subview.err_msg',['err'=> 'password' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <input type="password" id="password" name="password" placeholder="パスワード(6文字以上)" class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-input <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required autcomplate="new-password">
                            </div>

                            <!--password入力(確認用)-->
                            <div class="pass-area">
                                <?php echo $__env->make('subview.err_msg',['err'=> 'password_confirmation' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <input type="password" id="password-confirm" name="password_confirmation" placeholder="パスワード(6文字以上)"class="<?php $__errorArgs = ['password_confirmaton'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err-input <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required autcomplate="new-password">
                            </div>


                            <div class="login-button">
                                <input type="submit" value="登録する">
                            </div>
                        </div>
                    </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base_entry',['title' => 'ユーザー登録'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/auth/register.blade.php ENDPATH**/ ?>