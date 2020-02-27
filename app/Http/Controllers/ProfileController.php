<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\MyFunc;
use App\User;
use App\Profile;
use App\Output;
use App\Information;
use App\Frienduser;
use App\Likeoutput;
use App\Board;
use DB;
use Log;

class ProfileController extends Controller{

    public function getInfo(Request $req){
        return "「axiosで取得しました」";
    }

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
        $user = User::select('users.id','name','profile','pic','year','month','engineer_history','work_flg')
                        ->leftJoin( 'profiles' , 'users.id' , 'profiles.user_id' )
                        ->where( 'delete_flg',0 )
                        ->where( 'users.id',$data['u_id'] )
                        ->first();

        //ユーザー情報に使用言語情報を追加
        $user = MyFunc::addSkills( $user ,$user_flg = true );

        if(!empty($user_id && empty($user))){
            Log::debug('パラメータ改竄の可能性あり');
            return redirect('/outputlist');
        }

        //viewで渡すために連想配列形式で$dataへ格納
        $data = $data + array('user' => $user );

        //アウトプットを取得する
        //ポスト送信判定
        if ($req->isMethod('post')){ //検索条件がある場合
            //トークンの削除
            unset($req['_token']);
            $search = $req->all();

            if(!empty(array_filter($search))){ 
              
                $user_output = Myfunc::getOpLists( $data['u_id'] , $search);

            }else{ //検索条件ない場合

                $user_output = MyFunc::getOpLists( $data['u_id'] , $search = false );

            }

        //検索条件なし（単純にプロフィール表示の場合）
        }else{

            $user_output = MyFunc::getOpLists( $data['u_id'] , $search = false );

        }
        //各アウトプットに使用プログラミング言語情報を格納
        $user_output = MyFunc::addSkills($user_output);

        //各アウトプットにライク数を格納
        $user_output = MyFunc::addLike($user_output);

        //viewで渡すために連想配列形式で$dataへ格納
        $data = $data + array( 'outputs' => $user_output);

        //プロフィールが自分の場合の処理
        if($data['u_id'] == $data['my_id']){
            //インフォメーション情報を取得
            $info_top  = Information::select('msg','created_at')->get();


            //インフォメーション（メッセージ)を取得
            $info_msg  = $this->infoMsg($data['my_id']);

            //インフォメーション（フレンド情報）を取得
            $info_friend = $this->infoFriend($data['my_id']);

            $info = [
                        'info_top' => $info_top,
                        'info_msg' => $info_msg,
                        'info_friends' => $info_friend,
                    ];

            $data = $data + $info;

            $req->flash();
            return view('contents.profile',$data);
    
        //プロフィールが自分じゃない場合の処理
        }else{
            $friend = [
                'friend_flg' => $this->checkFriend($data['u_id'],$data['my_id'])
            ];

      
            $data = $data + $friend;

            $req->flash();
            return view('contents.profile',$data);
            

        }
       
    }

    public function infoMsg($id){

        try{

            $msg_boards = array();
            
            //Log::debug('ステップ①：メッセージ掲示板データ取得'); 

            //ステップ①：メッセージ掲示板データ取得
            $msg_boards = Board::select('id' , 'my_id' , 'partner_id')
                                    ->where( 'delete_flg' , 0 )
                                    ->where( function ( $query ) use($id){
                                        $query->where('my_id',$id)  
                                                ->orWhere('partner_id',$id);
                                    })
                                    ->get();

            if(!$msg_boards->isEmpty()){
    
                    Log::debug('ステップ②：掲示板データを掲示板IDとパートナーIDに整理する');
                        //$boardのデータは、my_idもしくはpartner_idが自分のidと一致する掲示板情報を取得している
                        //partner_idがメッセージ相手のidになるように整理する
                        //my_idは不要
                 
                        foreach($msg_boards  as $key => $board){
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
                            if(!empty($msg[$key]) || !empty($partner_prof[$key]) ){
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

        $friends = Frienduser::select('friend_id')
                                ->where('user_id',$id)
                                ->get();

        if(!$friends->isEmpty()){
            foreach($friends as $key => $friend){
                $result[$key] = User::select('users.id','name','pic',)
                                        ->leftJoin( 'profiles' , 'users.id' , 'profiles.user_id' )
                                        ->where( 'delete_flg',0 )
                                        ->where( 'users.id',$friend->friend_id )
                                        ->first();
            }
        }
      
        return $result;
    }

    public function checkFriend($u_id,$my_id){
        //フレンド登録しているか確認 （返り値は1かnull)
        $flg = Frienduser::where('user_id',$my_id)
                            ->where('friend_id',$u_id)
                            ->count();

        //nullの場合は0を格納
        if(empty($flg)){
            $flg = 0;
        }
        return $flg;
    }

    
}
