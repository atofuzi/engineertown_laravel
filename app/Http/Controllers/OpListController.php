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

                dd($data);

            }else{ //ポスト送信されたが検索条件無し

                //DBからアウトプット情報を取得
                $data = MyFunc::getOpLists( $id = false , $search = false );

            }

        
        }else{ //検索条件なし（単純にプロフィール表示の場合）

            //DBからアウトプット情報を取得
            $data = MyFunc::getOpLists( $id = false , $search = false );

            

        }
        
        //各アウトプット情報に使用言語情報を追加
        $data = $this->addSkills( $data );

        //各アウトプットのライク数を追加
        $data = $this->addLike( $data );

        //viewに渡すため連想配列にする
        $data =[ 'outputs' => $data ];
       
        //outputListを表示
        return view( 'contents.outputList' , $data );
        
    }

    public function addSkills( $outputs ){

        //各アウトプットに使用されているプログラミング言語情報を取得
        //各アウトプットの配列に連想配列'skill'を結合する
        foreach( $outputs as $key => $output ){
            $add_skills_output[$key] = $output;
            $add_skills_output[$key]['skill'] = $this->getOpSkills( $output->id );
            
        }
        return $add_skills_output;
}

    public function getOpSkills( $output_id ){

        //$idを使い該当するアウトプットの利用言語情報を取得する
        $output_skills = Output::select( 'html_flg' , 'css_flg' , 'js_jq_flg' ,
                                  'sql_flg' , 'java_flg' , 'php_flg' , 'php_oj_flg' , 
                                  'php_fw_flg' , 'ruby_flg' , 'rails_flg' , 'laravel_flg' , 
                                  'swift_flg' , 'scala_flg' , 'go_flg' , 'kotolin_flg' )
                            ->where( 'id' , $output_id )
                            ->where( 'delete_flg' , 0 ) 
                            ->first();
        
        //コレクションオブジェクトを配列化
        $output_skills = $output_skills->toArray();

        return $output_skills;

    }

    public function addLike( $outputs ){
        //各アウトプットのライク数を取得
        //各アウトプットのオブジェクトに連想配列'like'を結合する
        foreach( $outputs as $key => $output ){
            $add_like_output[$key] = $output;
            $add_like_output[$key]['like'] = $this->getOpLike( $output->id );
        }
  
        return $add_like_output;
    }

    public function getOpLike($output_id){
        $output_like = Likeoutput::where( 'op_id' , $output_id )->count();
        return $output_like; 
    }
}
