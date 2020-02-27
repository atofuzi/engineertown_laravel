<!--ヘッダーメニュ-->
<?php $__env->startSection('menu'); ?>
        <ul>
            <li><a href="/board">掲示板</a></li>
            <li><a href="/profile">マイページ</a></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
<?php if(count($errors) > 0): ?>
    <ul>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="err-msg"><?php echo e($err); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
        <section class="profEdit-burner">
        
            <h2 class="profEdit-title">プロフィール編集</h2>
                <!--プロフィール画像登録-->
                <!--DBにプロフィール画像が登録されていたら背景色を黒にする-->
                <div class="profEdit-img" style="<?php echo e(empty($user->pic) ?: 'background: #000;'); ?>">
                    <!--DBにプロフィール画像が登録されていたら画像を表示-->
                    <div class="img-style js-prof-img" style="background-image: <?php echo e($user->pic ? 'url('.$user->pic.');' : ''); ?>">
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
                <p class="<?php echo e(!empty($errors->common) ?: 'err-msg'); ?>"><?php echo e(!empty($errors->common) ? $errors->common : ''); ?></p>
                <div id="vue-input-text-1">
                    <label for="name">ニックネーム </label><br>
                    <?php echo $__env->make('subview.err_msg',['err' => 'name' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <input-text-component 
                        input-text="<?php echo e(old('name' , $user->name)); ?>"
                        input-Content="name"
                        placeholder=""
                    ></input-text-component>
                </div>
                <div id="vue-textarea">
                    <label for="profile">プロフィール</label><br>
                    <?php echo $__env->make('subview.err_msg',['err' => 'profile' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <textarea-component 
                        input-val="<?php echo e(old('profile' , $user->profile)); ?>"
                    ></textarea-component>
                </div>
            </div>
            <div class="skills">
                <p>・習得言語</p>
                <div id="vue-skills">
                    <skills-component 
                        :user-skills="<?php echo e($user); ?>"
                        :old="<?php echo e(json_encode(Session::getOldInput())); ?>"
                    ></skills-component>
                </div>
            </div>
            <div class="question">
                <div id="vue-input-text-2">
                    <p>・学習開始時期　※初学者のみ</p>
                    <label>
                    <input-text-component 
                        input-text="<?php echo e(old('year' , $user->year)); ?>"
                        input-Content="year"
                        placeholder="2019"
                    ></input-text-component>年</label>
                    <label>
                    <input-text-component 
                        input-text="<?php echo e(old('month' , $user->month)); ?>"
                        input-Content="month"
                        placeholder="1"
                    ></input-text-component>月</label>

                    <p>・エンジニア歴</p>
                    <label>
                    <input-text-component 
                        input-text="<?php echo e(old('engineer_history' , $user->engineer_history)); ?>"
                        input-Content="engineer_history"
                        placeholder="0"
                    ></input-text-component>年</label>
                </div>
                <div id="vue-radio">
                    <p>・実務経験</p>
                    <input type="hidden" name="work_flg" value=2>
                    <input-radio-component
                        radio-checked="<?php echo e($user->work_flg); ?>"
                        old="<?php echo e(old('work_flg')); ?>"
                        id="work_flg"
                        :choices="['なし','あり']"
                    ></input-radio-component><br>
                </div>
            </div>
            
            <input type="submit" value="変更する"/>
        </section> 
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base_contents',['title' => 'プロフィール編集'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/contents/profEdit.blade.php ENDPATH**/ ?>