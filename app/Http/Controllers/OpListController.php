<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Output;
use App\Information;
use App\Frienduser;
use App\Likeoutput;
use App\Library\MyFunc;
use DB;
use Log;

class OpListController extends Controller{
    
    public function showList( Request $req ){

        //アウトプットを取得する
        if( $req->isMethod('post') ){ //ポスト判定
            
            //トークンの削除
            unset( $req['_token'] );
            $search = $req->all();

            if( !empty(array_filter($search)) ){ //検索条件がある場合

                //DBから検索条件を満たすアウトプット情報を取得
                $data = MyFunc::getOpLists( $id = false , $search );

                

            }else{ //ポスト送信されたが検索条件無し

                //DBからアウトプット情報を取得
                $data = MyFunc::getOpLists( $id = false , $search = false );

            }

        
        }else{ //検索条件なし（単純にプロフィール表示の場合）

            //DBからアウトプット情報を取得
            $data = MyFunc::getOpLists( $id = false , $search = false );

            

        }
        
        //各アウトプット情報に使用言語情報を追加
        $data = MyFunc::addSkills( $data );

        //各アウトプットのライク数を追加
        $data = MyFunc::addLike( $data );

        //viewに渡すため連想配列にする
        $data =[ 'outputs' => $data ];
       
        //outputListを表示
        return view( 'contents.outputList' , $data );
        
    }
}