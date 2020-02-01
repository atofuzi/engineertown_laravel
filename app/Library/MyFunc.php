<?php

namespace App\Library;
use App\Output;
use App\Profile;
use DB;

class MyFunc{
    
    public static function getPath($file){

        if(!empty($file)){
            //ファイルを保存しパファイル名・パスを自動生成
            $path = $file->store('public');
            
            //パスを変換（publicをstorageへ)
            $path = str_replace('public', 'storage', $path);
    
            return $path;
        }else{
            return "";
        }

    }

    //スタンダードオブジェクトを配列化する関数
    public static function toArray($std_object){
            if(count($std_object) == 1){
                foreach($std_object[0] as $key => $value){
                    $array[$key] = $value;
                }
            }else{ 
                foreach($std_object as $index => $object){
                    foreach($object as $key => $value){
                        $array[$index][$key] = $value;
                    }
                }
            }
            return $array;
    }
    //アウトプットを取得するための関数
    public static function  getOpLists( $user_id=false , $search=false ){

            if( !empty($user_id) && !empty($search) ){ //プロフィール画面で検索条件あり
            
                $sql = 'SELECT  op.id , op.user_id , op.op_name , op.explanation , op.pic_main ,
                                op.movie ,op.html_flg , op.css_flg ,op.js_jq_flg , op.sql_flg , 
                                op.java_flg , op.php_flg , op.php_oj_flg , op.php_fw_flg , op.ruby_flg , 
                                op.rails_flg , op.laravel_flg , op.swift_flg , op.scala_flg , op.go_flg ,
                                op.kotolin_flg ,　op.created_at , p.pic AS pic_user
                        FROM `outputs` AS op LEFT JOIN profiles AS p ON op.user_id = p.user_id WHERE';
                
                //SQL文のWHEREの後にSQL文を追加するのが初回かどうかを判定するカウンター
                $count = 0;

                //検索条件にキーワードが指定されている場合
                if( !empty($search['keyword']) ){
                    //タイトルまたは説明にkeywordが含まれているかを検索するSQL
                    $sql .= 'op.op_name LIKE :op_name OR op.explanation LIKE :explanation ';
                    $data['op_name'] = '%'.$search['keyword'].'%';
                    $data['explanation'] = '%'.$search['keyword'].'%';
                    //SQLに追加されたためカウンター+1
                    $count++;
                }
                
                //以降の処理に影響が出るため削除
                unset($search['keyword']);

                //検索条件(チェックボックス）によってsqlを動的に書き換えるための処理
                foreach( $search as $key => $value ){
                    //検索条件の言語にチェックがある場合
                    if( !empty($search[$key]) ){
                        //sql文への追記が初回の場合はANDを付けない
                        if( $count === 0 ){
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

                //検索条件により自動生成したSQLで取得
                $result = DB::select($sql,$data);

                return $result;

            }elseif( !empty($user_id) && empty($search) ){ //プロフィール画面で検索条件なし
                $result = User::select()
                                    ->leftJoin( 'outputs' , 'users.id' , 'outputs.user_id' )
                                    ->where( 'delete_flg',0 )
                                    ->where( 'user_id',$data['u_id'] )
                                    ->get();

                return $result;
        
            }elseif( empty($user_id) && !empty($search) ){ //掲示板で検索条件あり
                           
                $count= 0;
                $sql = 'SELECT  op.id , op.user_id , op.op_name AS `name` , op.explanation , op.pic_main ,
                                op.movie ,op.created_at , p.pic AS pic_user
                        FROM `outputs` AS op LEFT JOIN profiles AS p ON op.user_id = p.user_id WHERE ';

                //検索条件にキーワードが指定されている場合
                if( !empty($search['keyword']) ){
                    $sql .= 'op.op_name LIKE :op_name OR op.explanation LIKE :explanation ';
                    $data['op_name'] = '%'.$search['keyword'].'%';
                    $data['explanation'] = '%'.$search['keyword'].'%';
                    $count++;
                }
                unset( $search['keyword'] );

                //検索条件によってsqlを動的に書き換えるための処理
                foreach( $search as $key => $value ){
                    //検索条件の言語にチェックがある場合
                    if( !empty($search[$key]) ){
                        //sql文への追記が初回の場合はANDを付けない
                        if( $count === 0 ){
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

                $result = DB::select($sql,$data);


                return $result;

            }else{  //掲示板で検索条件無し

                $result = Output::select('outputs.id','outputs.user_id','op_name as name','explanation','pic_main','pic_sub1','pic_sub2','movie','pic as pic_user','outputs.created_at')
                                    ->leftJoin('profiles','outputs.user_id','profiles.user_id')
                                    ->where('outputs.delete_flg',0)
                                    ->orderBy('outputs.created_at','desc')
                                    ->get();
                
                return $result;

            }
    }

}
