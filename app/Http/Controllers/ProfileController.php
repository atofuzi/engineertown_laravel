<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Output;
use App\Information;
use App\Frienduser;
use App\Likeoutput;
use DB;
use Log;

class ProfileController extends Controller{

    public function showProfile(Request $req,$user_id=""){

        $search = [
            'search' => array()
        ];

        //プロフィール表示するユーザーidを$data['u_id']へ格納
        if(!empty($user_id)){
            $data = [
                'u_id' => $user_id
            ];
        }else{
            $data = [
                'u_id' => $req->session()->get('user_id')
            ];
        }
        //自分自身のidをmy_idとして格納
        $data = $data + array('my_id'=>$req->session()->get('user_id'));

        //user_idでプロフィール表示するユーザー情報を取得
        $data = $data + array('user' => User::find($data['u_id']));

    

        if(!empty($user_id && empty($data['user']))){
            Log::debug('パラメータ改竄の可能性あり');
            return redirect('/outputlist');
        }

        //リレーションで結合されたプロフィール情報を取得
        $profile =  $data['user']->profile;
        //コレクションオブジェクトを配列化
        $profile =  $profile->toArray();
            
        //profileの配列データをオブジェクトdata['user']に追加→bladeでの記述を簡単にするため
        foreach($profile as $key => $value){
            $temp = $data['user'];
            $temp[$key] = $value;
            $data['user'] = $temp;
        }

        //ユーザー保有スキルを配列形式でセット→bladeでforeachで展開するため
        $data = $data + array('user_skill'=> $this->getUserSkill($data['user']));

        //アウトプットを取得する
        //検索条件がある場合（ポスト送信判定）
        if ($req->isMethod('post')){
            //トークンの削除
            unset($req['_token']);
            $search = $req->all();

            if(!empty(array_filter($search))){ 
              
                $output= [
                    'op_lists' => $this->getOpLists($data['u_id'],$search)
                ];
            }else{

                $output = [
                    'op_lists' => User::select()
                                    ->leftJoin('outputs','users.id','outputs.user_id')
                                    ->where('delete_flg',0)->where('user_id',$data['u_id'])
                                    ->get()
                    ];
            }

        //検索条件なし（単純にプロフィール表示の場合）
        }else{

            $output = [
                    'op_lists' => User::select()
                                    ->leftJoin('outputs','users.id','outputs.user_id')
                                    ->where('delete_flg',0)->where('user_id',$data['u_id'])
                                    ->get()
                    ];
            //リレーションで結合されたアウトプット情報を取得
            //$output_r = ['op_lists' => $data['user']->outputs];
        }

        //アウトプットで使用されたスキル（言語）情報を連想配列形式で取得
        $output = $output + array('op_skill' => $this->getOpSkill($output));

        //アウトプットのライク数を連想配列形式で取得
        $output = $output + array('op_like' => $this->getOpLike($output));
     
        //プロフィールが自分の場合の処理
        if($data['u_id'] == $data['my_id']){
            //インフォメーション情報を取得
            $temp = Information::select('msg','created_at')->get();

            $info = [
                'info' => $temp->toArray()
            ];
       
            Log::debug($info);

            //インフォメーション（メッセージ)を取得
            $info = $info + array('info_msg' => $this->infoMsg($data['my_id']));

            //インフォメーション（フレンド情報）を取得
            //my_idで検索したフレンドのUserテーブルとリレーションされたprofileテーブルの情報が戻ってくる
            $info = $info + array('info_friends' => $this->infoFriend($data['my_id']));

            $data = $data + $output + $info +$search;

            $req->flash();
            return view('contents.profile',$data);
    
        //プロフィールが自分じゃない場合の処理
        }else{
            $friend = [
                'friend_flg' => $this->checkFriend($data['u_id'],$data['my_id'])
            ];

      
            $data = $data + $output + $friend + $search;

            $req->flash();
            return view('contents.profile',$data);
            

        }
       
    }


    public function getUserSkill($object){

            $result = array(
                        'HTML' => $object->html_flg ,
                        'CSS' => $object->css_flg ,
                        'javascript・jquery' => $object->js_jq_flg ,
                        'SQL' => $object->sql_flg ,
                        'JAVA' => $object->java_flg ,
                        'PHP' => $object->php_flg ,
                        'PHP(オブジェクト指向)' => $object->php_oj_flg ,
                        'PHP(フレームワーク)' => $object->php_fw_flg ,
                        'ruby' => $object->ruby_flg ,
                        'rails' => $object->rails_flg ,
                        'laravel' => $object->laravel_flg ,
                        'swift' => $object->swift_flg ,
                        'scala' => $object->scala_flg ,
                        'go' => $object->go_flg ,
                        'kotolin' => $object->kotolin_flg
                    );

            return $result;
    }

    public function getOpLists($id,$search){
        $count = 0;
                $sql = 'SELECT  op.id , op.user_id , op.op_name , op.explanation , op.pic_main ,
                        op.movie ,op.html_flg , op.css_flg ,
                        op.js_jq_flg , op.sql_flg , op.java_flg , op.php_flg , op.php_oj_flg , 
                        op.php_fw_flg , op.ruby_flg , op.rails_flg , op.laravel_flg , 
                        op.swift_flg , op.scala_flg , op.go_flg , op.kotolin_flg ,
                        op.created_at , p.pic AS pic_user
                FROM `outputs` AS op LEFT JOIN profiles AS p ON op.user_id = p.user_id WHERE ';

                //検索条件にキーワードが指定されている場合
                if(!empty($search['keyword'])){
                    $sql .= 'op.op_name LIKE :op_name OR op.explanation LIKE :explanation ';
                    $data['op_name'] = '%'.$search['keyword'].'%';
                    $data['explanation'] = '%'.$search['keyword'].'%';
                    $count++;
                }
                unset($search['keyword']);

                //検索条件によってsqlを動的に書き換えるための処理
                foreach($search as $key => $value){
                    //検索条件の言語にチェックがある場合
                    if(!empty($search[$key])){
                        //sql文への追記が初回の場合はANDを付けない
                        if($count === 0){
                            $sql .= 'op.'.$key.'= :'.$key.' ';
                            $data[$key] = $value;
                            $count++;
                        }else{
                            $sql .= 'AND op.'.$key.'= :'.$key.' ';
                            $data[$key] = $value;
                            $count++;
                        }
                    }
                }
         
                //sqlの最後に必ず追記する
                $sql .= 'AND op.delete_flg = :delete_flg AND op.user_id = :user_id ORDER BY op.created_at DESC';

                $data['delete_flg'] = 0;
                $data['user_id'] = $id;

                $result = DB::select($sql,$data);

                return $result;
                
        }

    public function getOpSkill($objects){

        $result = array();
        
        if(!empty($objects['op_lists'])){

            foreach($objects['op_lists'] as $key => $object){
                $result[$key] = array(
                            'HTML' => $object->html_flg ,
                            'CSS' => $object->css_flg ,
                            'javascript・jquery' => $object->js_jq_flg ,
                            'SQL' => $object->sql_flg ,
                            'JAVA' => $object->java_flg ,
                            'PHP' => $object->php_flg ,
                            'PHP(オブジェクト指向)' => $object->php_oj_flg ,
                            'PHP(フレームワーク)' => $object->php_fw_flg ,
                            'ruby' => $object->ruby_flg ,
                            'rails' => $object->rails_flg ,
                            'laravel' => $object->laravel_flg ,
                            'swift' => $object->swift_flg ,
                            'scala' => $object->scala_flg ,
                            'go' => $object->go_flg ,
                            'kotolin' => $object->kotolin_flg
                        );
                }
        }
        
        return $result;
    }

    public function getOpLike($objects){
        
        $count = "";
        if(!empty($objects['op_lists'])){
            foreach($objects['op_lists'] as $key => $object){
                $count[$key] = Likeoutput::where('op_id', $object->id)->count();
            }
        }
        return $count;
    }

    public function infoMsg($id){
        try{

            $boards = array();
            
            Log::debug('ステップ①：掲示板データ取得'); 

            $sql = 'SELECT id , my_id , partner_id
                    FROM `boards` 
                    WHERE (my_id = :my_id OR partner_id = :partner_id ) AND delete_flg = :delete_flg';

            $data = array('my_id' => $id ,'partner_id' => $id , 'delete_flg' => 0); 

            $boards= DB::select($sql,$data);
    
    
            if(!empty($boards)){
    
                    Log::debug('ステップ②：掲示板データを掲示板IDとパートナーIDに整理する');
                        //$boardのデータは、my_idもしくはpartner_idが自分のidと一致する掲示板情報を取得している
                        //partner_idがメッセージ相手のidになるように整理する
                        //my_idは不要
                 
                        foreach($boards as $key => $board){
                            //my_idが自分のidだった場合はそのままpartner_idを格納
                            if($board->my_id === $id){
                                $board_data[$key]= array(
                                                        'id' => $board->id ,
                                                        'partner_id' => $board->partner_id
                                                    );       

                            //partner_idが自分のidだった場合はmy_idをpartner_idとして格納
                            }elseif($board->partner_id === $id){
                                $board_data[$key] = array(
                                                        'id' => $board->id,
                                                        'partner_id' => $board->my_id
                                                    );          
                            }
                        }
               
                    Log::debug('掲示板IDとパートナーID'.print_r($board_data,true));
                    log::debug('ステップ③：メッセージデータを取得'); 
                    log::debug('ステップ④：パートナー画像取得'); 
   
    
                    //board_idに関連するメッセージデータのうち、新しいメッセージ順に取得するSQL文
                    $sql1 = 'SELECT board_id , msg , created_at
                            FROM `messages` WHERE board_id = :board_id AND delete_flg = :delete_flg ORDER BY created_at DESC limit 1';
    
                    //partner_idの名前とプロフィール画像を取得するSQL文(インフォメーションボックスで画像を表示するため)
                    $sql2 = 'SELECT u.id AS user_id , u.name AS `name` , p.pic AS pic FROM `users` AS u LEFT JOIN profiles AS p ON u.id = p.user_id WHERE `user_id` = :user_id AND delete_flg = :delete_flg';
    
                    //存在するboard_id分、SQL1、SQL2を展開する
                    foreach($board_data as $key => $value){
                        $data1 = array(':board_id' => $board_data[$key]['id'] , ':delete_flg' => 0); 
                        $data2 = array(':user_id' => $board_data[$key]['partner_id'] , ':delete_flg' => 0);
                        
                        //stdオブジェクト形式で戻ってくる
                        $msg[$key] = DB::select($sql1,$data1);
                        $partner_prof[$key] = DB::select($sql2,$data2);
              

                            //掲示板画面に遷移しただけでメッセージのやり取りをしていない場合は処理を行わない
                            if(!empty($msg[$key]) || !empty($partner[$key]) ){
                                //オブジェクトのメンバを連想配列として格納する
                                $result[$key]['id'] = $partner_prof[$key][0]->user_id;
                                $result[$key]['name'] = $partner_prof[$key][0]->name;
                                $result[$key]['pic'] = $partner_prof[$key][0]->pic;
                                $result[$key]['board_id'] = $msg[$key][0]->board_id;
                                $result[$key]['msg'] = $msg[$key][0]->msg;
                                $result[$key]['created_at'] = $msg[$key][0]->created_at;
                            }
                    }           
                return $result;
            }

            return $result;
        } catch (Exception $e){
         
        }
    
    
    }

    public function infoFriend($id){
        $result = array();

        $friends = Frienduser::select('friend_id')->where('user_id',$id)->get();

        if(!empty($friends)){
            foreach($friends as $key => $friend){
                $result[$key] = User::find($friend->friend_id);
            }
        }

        return $result;
    }

    public function checkFriend($u_id,$my_id){
        //フレンド登録しているか確認 （返り値は1かnull)
        $flg = Frienduser::where('user_id',$my_id)->where('friend_id',$u_id)->count();

        //nullの場合は0を格納
        if(empty($flg)){
            $flg = 0;
        }
        return $flg;
    }

    
}
