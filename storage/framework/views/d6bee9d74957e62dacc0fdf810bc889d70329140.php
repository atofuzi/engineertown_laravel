<!--ヘッダーメニュ-->
<?php $__env->startSection('menu'); ?>
    <?php if($u_id == $my_id): ?>
        <ul>
            <li><a href="/outputList">掲示板</a></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
    <?php else: ?>
        <ul>
            <li><a href="/outputList">掲示板</a></li>
            <li><a href="/profile">マイページ</a></li>
            <li><a href="/logout">ログアウト</a></li>
        </ul>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
    <section class="profEdit-burner">
        <h2 class="profEdit-title"><?php echo e($user->name); ?></h2>
        <nav class="nav-prof">
            
        <?php if($u_id != $my_id): ?>

            
            <form action="message.php" method="post">
                <a href="<?php echo 'message.php?u_id='.$u_id;?>"><div class="mail-icon"><i class="far fa-envelope"></i></div></a>
            </form>
            <div id="js-click-friend" class="friend-icon <?php echo e($friend_flg ? 'active' : ''); ?>" aria-hidden="true" data-friend="<?php echo e($u_id); ?>">
                <?php echo e($friend_flg ? 'フレンド中' : 'フレンド登録'); ?>

            </div>
        
        <?php elseif($u_id == $my_id): ?>
            
            
             <a href="/profEdit">
                <div class="prof-icon">プロフィール変更</div>
            </a>

        <?php endif; ?>

        </nav>

        
        <!--プロフィール画像-->
        <div class="profEdit-img">
            <div class="img-style" style="opacity: 1; background-image: <?php echo e($user->pic ? 'url('.$user->pic.');' : ''); ?>"></div>
        </div>
           
    </section>

    <!--　プロフィールテーブル -->
    <section class="prof-area">
        <table>
            <tr>
                <th align="left">プロフィール</th>
                <td><?php echo e($user->profile ?: $user->profile); ?></td>
            <tr>
            <tr>
                <th align="left">学習開始時期</th>
                <td><?php if(!empty($user->year)): ?><?php echo e($user->year.'年'.$user->month.'月'); ?> <?php endif; ?></td>
            <tr>
            <tr>
                <th align="left">プログラミング歴</th>
                <td><?php if(isset($user->engineer_history)): ?><?php echo e($user->engineer_history.'年'); ?> <?php endif; ?></td>
            <tr>
            <tr>
                <th align="left">実務経験</th>
                <td><?php echo e($user->work_flg ? 'あり' : 'なし'); ?></td>
            <tr>
            <tr>
                <th align="left">習得言語</th>
                <td>
                        <?php $__currentLoopData = $user->skill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($user->skill[$language]==1): ?>
                                <span><?php echo e(Skills::get($language).' , '); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
            <tr>
        </table>
    </section>

    
    <?php if($u_id == $my_id): ?>

    
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
                <?php if(!empty($info_top)): ?>
                    <?php $__currentLoopData = $info_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                        <div><?php echo e($info->created_at); ?></div>
                        <div><?php echo e($info->msg); ?></div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php else: ?>
                    <?php echo e('お知らせはありません'); ?>

                <?php endif; ?>
            </div>

            </template>
            <template v-else-if="isActive === '2' ">
            <!--タブ：メッセージボード欄-->

            <div class="content" id="js-scroll-bottom">
                <?php $__currentLoopData = $info_msg; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo 'message.php?u_id='.$info_msg[$key]['id']; ?>">
                        <div class="info-msg-wrap">
                            <div class="info-msg-img" style="background-image: url(<?php echo e($info_msg[$key]['pic'] ? $info_msg[$key]['pic'].');' : 'storage/no_image.png);'); ?>"></div>
                            <div class="info-msg">
                                <!--メッセージ相手の名前-->
                                <h3>
                                    <?php if(!empty($info_msg[$key]['name'])): ?>
                                        <?php echo e($info_msg[$key]['name']); ?>

                                    <?php else: ?>
                                        <?php echo e("no-name"); ?> 
                                    <?php endif; ?>
                                </h3>
                                <!--メッセージ-->
                                <p>
                                    <?php if(!empty($info_msg[$key]['msg'])): ?>
                                        <?php echo e($info_msg[$key]['msg']); ?>

                                    <?php else: ?>
                                        <?php echo e(""); ?> 
                                    <?php endif; ?>
                                </p>
                            </div>
                            <!--投稿日-->
                            <p>
                            <?php if(!empty($info_msg[$key]['created_at'])): ?>
                                <?php echo e($info_msg[$key]['created_at']); ?>

                            <?php else: ?>
                                <?php echo e(""); ?>

                            <?php endif; ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            </template>
            <template v-else-if="isActive === '3' ">
            <!--タブ：フレンドリスト欄-->

            <div class="content">
                    <div class="info-friend-list">
                    <?php $__currentLoopData = $info_friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo 'profDetail.php?u_id='.$friend->id; ?>">
                            <div class="info-friend-wrap">
                                <div class="info-friend-img" style="background-image: url(<?php echo e($friend->pic ? $friend->pic.');' : 'storage/no_image.png);'); ?>"></div>
                                <h3><?php echo e($friend->name ? $friend->name : 'no-name'); ?></h3>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
            </div>
            </template>
        </div>
    </section>
    
    <?php endif; ?>

    <!-- アウトプットリスト見出し-->
    <h2><i class="fas fa-list-ul" style="margin-right:5px;"></i> OUTPUT　List</h2>

    <!-- 検索 -->
    <form action="/profile/<?php echo e($u_id); ?>" method="post" id="contents" enctype="multipart/form-data" class="wrap">
        <?php echo csrf_field(); ?>
        <div class='keyword-search-area'>
            <input type="search" name="keyword" placeholder="キーワードを入力" class="keyword" value="<?php echo e(old('keyword','')); ?>">
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
                                <label><input type="checkbox" name="html_flg" value=1 <?php echo e(old("html_flg") == 1 ? 'checked="checked"' : ''); ?>>HTML</label>
                            </td>
                            <td>
                                <input type="hidden" name="css_flg" value="">
                                <label><input type="checkbox" name="css_flg" value=1 <?php echo e(old("css_flg") == 1 ? 'checked="checked"' : ''); ?>>CSS</label>
                            </td>
                            <td>
                                <input type="hidden" name="js_jq_flg" value="">
                                <label><input type="checkbox" name="js_jq_flg" value=1 <?php echo e(old("js_jq_flg") == 1 ? 'checked="checked"' : ''); ?>>javascript・jquery</label>
                            </td>
                            <td>
                                <input type="hidden" name="sql_flg" value="">
                                <label><input type="checkbox" name="sql_flg" value=1 <?php echo e(old("sql_flg") == 1 ? 'checked="checked"' : ''); ?>>SQL</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="java_flg" value="">
                                <label><input type="checkbox" name="java_flg" value=1 <?php echo e(old("java_flg") == 1 ? 'checked="checked"' : ''); ?>>JAVA</label>
                            </td>
                            <td>
                                <input type="hidden" name="php_flg" value="">
                                <label><input type="checkbox" name="php_flg" value=1 <?php echo e(old("php_flg") == 1 ? 'checked="checked"' : ''); ?>>PHP</label>
                            </td>
                            <td>
                                <input type="hidden" name="php_oj_flg" value="">
                                <label><input type="checkbox" name="php_oj_flg" value=1 <?php echo e(old("php_oj_flg") == 1 ? 'checked="checked"' : ''); ?>>PHP（オブジェクト指向)</label>
                            </td>
                            <td>
                                <input type="hidden" name="php_fw_flg" value="">
                                <label><input type="checkbox" name="php_fw_flg" value=1 <?php echo e(old("php_fw_flg") == 1 ? 'checked="checked"' : ''); ?>>PHP（フレームワーク）</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="ruby_flg" value="">
                                <label><input type="checkbox" name="ruby_flg" value=1 <?php echo e(old("ruby_flg") == 1 ? 'checked="checked"' : ''); ?>>ruby</label>
                            </td>
                            <td>
                                <input type="hidden" name="rails_flg" value="">
                                <label><input type="checkbox" name="rails_flg" value=1 <?php echo e(old("rails_flg") == 1 ? 'checked="checked"' : ''); ?>>rails</label>
                            </td>
                            <td>
                                <input type="hidden" name="laravel_flg" value="">
                                <label><input type="checkbox" name="laravel_flg" value=1 <?php echo e(old("laravel_flg") == 1 ? 'checked="checked"' : ''); ?>>laravel</label>
                            </td>
                            <td>
                                <input type="hidden" name="swift_flg" value="">
                                <label><input type="checkbox" name="swift_flg" value=1 <?php echo e(old("swift_flg") == 1 ? 'checked="checked"' : ''); ?>>swift</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="scala_flg" value="">
                                <label><input type="checkbox" name="scala_flg" value=1 <?php echo e(old("scala_flg") == 1 ? 'checked="checked"' : ''); ?>>scala</label>
                            </td>
                            <td>
                                <input type="hidden" name="go_flg" value="">
                                <label><input type="checkbox" name="go_flg" value=1 <?php echo e(old("go_flg") == 1 ? 'checked="checked"' : ''); ?>>go</label>
                            </td>
                            <td>
                                <input type="hidden" name="kotolin_flg" value="">
                                <label><input type="checkbox" name="kotolin_flg" value=1 <?php echo e(old("kotolin_flg") == 1 ? 'checked="checked"' : ''); ?>>kotolin</label>
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
        <?php if($u_id === $my_id): ?>

        
            <div>
                <a href="/outputRegist" class="list-input-area">
                    <i class="fas fa-folder" style="font-size:24px;"></i><span>Listへ追加+</span>
                </a>
            </div>
        <?php endif; ?>

        <!--　アウトプットをパネルで一覧表示 -->
        <?php if(!empty($outputs)): ?>
            <?php $__currentLoopData = $outputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $output): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="panel-list">
                    
                    <?php if($u_id !== $my_id): ?>

                    
                        <a href="profDetail/<?php echo e($u_id); ?>">
                            <div class="user-img">
                                <img src="<?php echo e($user->pic); ?>">
                            </div>
                        </a>

                    <?php else: ?>

                    
                        <div class="menu-icon">
                            <i class="fas fa-bars js-menu-icon"></i>
                            <i class="fas fa-times js-menu-icon" style="display: none;"></i>
                            <nav style="display: none;">
                                <ul>
                                    <li><a href="outputEdit/<?php echo e($output->id); ?>">編集</a></li>
                                    <li class="op-delete" aria-hidden="true" data-deleteid="<?php echo e($output->id); ?>">削除</li>
                                </ul>
                            </nav>
                        </div>

                    <?php endif; ?>
                
                <div class="wrap">
                        <a href="<?php echo e($u_id === $my_id ? '/outputEdit/'.$output->id : 'outputDetail/'.$output->id); ?>" class="panel">
                            <p class="panel-title">作品名 : <?php echo e($output->name); ?></p>
                            <div class="panel-img">
                                <img src="<?php echo e($output->pic_main); ?>">
                            </div>
                            <div class="panel-comment">
                                <label>【アウトプット概要】
                                    <p><?php echo e($output->explanation); ?></p>
                                </label>
                            </div>
                            <div class="panel-skills">
                                <label>【使用言語】
                                <p>
                                    <?php $__currentLoopData = $output->skill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($output->skill[$language]==1): ?>
                                            <?php echo e(Skills::get($language).' , '); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>
                                </label>
                            </div>
                        </a>
                    <p class="post-date">投稿日： <?php echo e($output->created_at); ?></p>
                    <div class="like-icon-area">
                        <i class="fa fa-heart icn-like js-click-like <?php echo e(!$output->like ?: 'active'); ?>" aria-hidden="true" data-output="<?php echo e($output->id); ?>">
                            <span class="js-like-count">
                            <?php if(!empty($output->like)): ?>
                                <?php echo e($output->like); ?>

                            <?php else: ?>
                                <?php echo e(""); ?>

                            <?php endif; ?>    
                        </span>
                        </i>
                    </div>
                </div>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base_contents',['title' => 'プロフィール'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/contents/profile.blade.php ENDPATH**/ ?>