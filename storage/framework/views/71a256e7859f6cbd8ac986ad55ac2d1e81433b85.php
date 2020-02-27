<?php $__env->startSection('menu'); ?>
    <ul>
        <li><a href="/outputList">掲示板</a></li>
        <li><a href="/profile">マイページ</a></li>
        <li><a href="/logout">ログアウト</a></li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>

<?php if(count($errors) > 0): ?>
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="text-danger"><?php echo e($err); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>

<form action="/outputUpdate/<?php echo e($output->id); ?>" method="post" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
        <h2 class="title"><?php echo e("アウトプット編集"); ?></h2>
        <!--　エラーメッセージ -->
        <?php echo $__env->make('subview.err_msg',['err'=> 'common' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <section class="output-regist">
                <div class="output-title">
                    <label>作品タイトル  <span style="color: #FF0000; padding-left: 10px;">※必須</span>
                        <!--エラーメッセージ表示エリア-->
                        <?php echo $__env->make('subview.err_msg',['err'=> 'op_name' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <!--作品タイトル入力蘭-->
                        <input type="text" name="op_name" class="op_name" value="<?php echo e(old('op_name', $output->op_name)); ?>"><br>
                    </label>
                </div>

                <div class="output-explanation">
                    <label>説明
                    <!--エラーメッセージ表示エリア-->
                    <?php echo $__env->make('subview.err_msg',['err'=> 'explanation' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      <!--作品説明入力蘭-->
                    <textarea name="explanation" id="js-count"><?php echo e(old( 'explanation',$output->explanation)); ?></textarea>
                    </label>
                    <p class="counter-text"><span class="js-count-view"><?php if(!empty(old('explanation'))): ?> <?php echo e(mb_strlen(old('explanation'))); ?> <?php else: ?> <?php echo e(mb_strlen($output->explanation)); ?> <?php endif; ?></span>/255文字</p>
                </div>

                <div class="pic-area" style="overflow: hidden;"> 

                    <!--メイン画像-->
                    <div class="pic-main">
                      <p>
                        【メイン画像】
                         <span style="color: #FF0000;">※必須</span>
                         <?php echo $__env->make('subview.err_msg',['err'=> 'pic_main' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                      </p>
                        <div class="area-drop-main js-area-drop">
                        <input type="file" name="pic_main" class="input-area js-file-input">
                        <img class="img-area js-file-prev" src="<?php echo e(old('pic_main', asset($output->pic_main) )); ?>">
                        ドラッグ&ドロップ
                        <i class="fas fa-times prev-close" style="display: none;"></i>
                        </div>
                    </div>
                    <!--サブ画像-->
                    
                    <div class="pic-sub"><p>【サブ画像①】</p>
                        <div class="area-drop-sub js-area-drop">
                        <input type="file" name="pic_sub1" class="input-area js-file-input" >
                        <img class="img-area js-file-prev" src="<?php echo e(old('pic_main', asset($output->pic_sub1) )); ?>">
                        ドラッグ&ドロップ
                        <i class="fas fa-times prev-close" style="display: none;"></i>
                        </div>
                    </div>
                      <!--サブ画像-->
                      <div class="pic-sub"><p>【サブ画像②】</P>
                        <div class="area-drop-sub js-area-drop">
                            <input type="file" name="pic_sub2" class="input-area js-file-input">
                            <img class="img-area js-file-prev" src="<?php echo e(old('pic_main', asset($output->pic_sub2) )); ?>">
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
                    <?php echo $__env->make('subview.err_msg',['err'=> 'movie' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </p>
                        <div class="area-drop-main js-area-drop">
                            <input type="file" name="movie" class="input-area js-file-input">
                            <video class="video-area js-file-prev" muted controls controlslist="nodownload" src="<?php echo e(old('pic_main', asset($output->movie) )); ?>"></video>
                                ドラッグ&ドロップ
                                <i class="fas fa-times prev-close" style="display: none;"></i>
                        </div>
                    </div>
                </div>

                <div class="skills-area" style="overflow: hidden;"> 
                    <div class="op-skills">
                        <p>・使用言語</p>
                        <input type="hidden" name="html_flg" value=0>
                        <label><input type="checkbox" name="html_flg" value=1 <?php echo e(old('html_flg',$output['html_flg']) ? 'checked' : ''); ?>>HTML</label><br>

                        <input type="hidden" name="css_flg" value=0>
                        <label><input type="checkbox" name="css_flg" value=1 <?php echo e(old('css_flg',$output['css_flg']) ? 'checked' : ''); ?>>CSS</label><br>

                        <input type="hidden" name="js_jq_flg" value=0>
                        <label><input type="checkbox" name="js_jq_flg" value=1 <?php echo e(old('js_jq_flg',$output['js_jq_flg']) ? 'checked' : ''); ?>>javascript・jquery</label><br>

                        <input type="hidden" name="sql_flg" value=0>
                        <label><input type="checkbox" name="sql_flg" value=1 <?php echo e(old('sql_flg',$output['sql_flg']) ? 'checked' : ''); ?>>SQL</label><br>

                        <input type="hidden" name="java_flg" value=0>
                        <label><input type="checkbox" name="java_flg" value=1 <?php echo e(old('java_flg',$output['java_flg']) ? 'checked' : ''); ?>>JAVA</label><br>

                        <input type="hidden" name="php_flg" value=0>
                        <label><input type="checkbox" name="php_flg" value=1 <?php echo e(old('php_flg',$output['php_flg']) ? 'checked' : ''); ?>>PHP</label><br>

                        <input type="hidden" name="php_oj_flg" value=0>
                        <label><input type="checkbox" name="php_oj_flg" value=1 <?php echo e(old('php_oj_flg',$output['php_oj_flg']) ? 'checked' : ''); ?>>PHP（オブジェクト指向)</label><br>

                        <input type="hidden" name="php_fw_flg" value=0>
                        <label><input type="checkbox" name="php_fw_flg" value=1 <?php echo e(old('php_fw_flg',$output['php_fw_flg']) ? 'checked' : ''); ?>>PHP（フレームワーク）</label><br>

                        <input type="hidden" name="ruby_flg" value=0>
                        <label><input type="checkbox" name="ruby_flg" value=1 <?php echo e(old('ruby_flg',$output['ruby_flg']) ? 'checked' : ''); ?>>ruby</label><br>

                        <input type="hidden" name="rails_flg" value=0>
                        <label><input type="checkbox" name="rails_flg" value=1 <?php echo e(old('rails_flg',$output['rails_flg']) ? 'checked' : ''); ?>>rails</label><br>

                        <input type="hidden" name="laravel_flg" value=0>
                        <label><input type="checkbox" name="laravel_flg" value=1 <?php echo e(old('laravel_flg',$output['laravel_flg']) ? 'checked' : ''); ?>>laravel</label><br>

                        <input type="hidden" name="swift_flg" value=0>
                        <label><input type="checkbox" name="swift_flg" value=1 <?php echo e(old('swift_flg',$output['swift_flg']) ? 'checked' : ''); ?>>swift</label><br>

                        <input type="hidden" name="scala_flg" value=0>
                        <label><input type="checkbox" name="scala_flg" value=1 <?php echo e(old('scala_flg',$output['scala_flg']) ? 'checked' : ''); ?>>scala</label><br>

                        <input type="hidden" name="go_flg" value=0>
                        <label><input type="checkbox" name="go_flg" value=1 <?php echo e(old('go_flg',$output['go_flg']) ? 'checked' : ''); ?>>go</label><br>

                        <input type="hidden" name="kotolin_flg" value=0>
                        <label><input type="checkbox" name="kotolin_flg" value=1 <?php echo e(old('kotolin_flg',$output['kotolin_flg']) ? 'checked' : ''); ?>>kotolin</label><br>
                    </div>

                </div>
                <input type="submit" value="登録する">
            </section> 
    </form>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base_contents',['title' => 'アウトプット編集'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/contents/outputEdit.blade.php ENDPATH**/ ?>