<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\library\MyFunc;
use App\User;
use App\Profile;
use Log;
use DB;

class profEditController extends Controller{

    public function getProfile(Request $req){
        
        //セッションからユーザーIDを取得
        $user_id = $req->session()->get('user_id');
        
        $data['user'] = $this->getUserProf($user_id);

        return view('contents.profEdit',$data);

    }
    
    public function registerProfile(ProfileRequest $req){
        //$this->validate($req->year,Profile::$rules);
        //$validatedData = $req->validate([
            //'name' => ['required',"min:6",'max:255'],
            //'profile' => ['string','min:6','max:255'],
            //'pic' => ['file','image','mimes:jpeg,png,jpg,gif','max:2048'],
            //'year' => ['numeric'],
            //'month' => ['numeric']
       //]);
    

        //セッションからユーザーIDを取得
        $user_id = $req->session()->get('user_id');
        
        //DBから編集対象のユーザー情報を取得
        $dbUserData = $this->getEditProf($user_id);

        //トークンを削除
        unset($req['_token']);

        //ポストデータを配列へ格納
        $profile = $req->all();
                    
        //更新データの準備
        //$dbUserDataを連想配列化
        $data = MyFunc::toArray($dbUserData);
        //更新数カウンター
        $count = 0;

        //画像データがポスト送信された場合、画像パスを取り出し配列へ格納
        if(!empty($req->pic)){
            
            $path = MyFunc::getPath($req->pic);
            
            //画像データのパスを格納
            $data['pic'] = $path;
            //picデータはオブジェクトなのでパスで上書き
            $profile['pic'] = $path;
            //更新カウントを＋１
            $count++;
        }
       
        //更新するデータを$dataへ全て格納
        foreach($profile as $key => $value){
            if($data[$key] != $profile[$key]){
                $data[$key] = $profile[$key];
                $count++;
            }
        }
        $data['id']= $user_id;

        if($count > 0){        
            //DB更新処理
            $this->upDateProf($data);
        }

        $req->flash();
        return redirect('/profEdit');
    }

    //スタンダードオブジェクトを配列化する関数
    public function toArray($std_object){
        if(count($std_object) == 1){
            foreach($std_object[0] as $key => $value){
                $array[$key] = $value;
            }
        }else{ 
            foreach($std_object as $index => $object){
                foreach($object[$index] as $key => $value){
                    $array[$index][$key] = $value;
                }
            }
        }
        return $array;
    }
    
    //ユーザー情報取得
    public function getUserProf($id){
        //ユーザーIDからユーザー情報を取得
        $dbUserData =  User::find($id);
        

        //Usersテーブルからリレーションされているプロフィール情報を取得
        $profile = $dbUserData->profile;

        //コレクションオブジェクトを配列化
        $profile =  $profile->toArray();

        //プロフィール情報を$data['user']へ格納→blade側の処理のため
        foreach($profile as $key => $value){
            $temp = $dbUserData;
            $temp[$key] = $value;
            $dbUserData = $temp;
        }
        return $dbUserData;
    }

    //編集対象のプロフィールを取得
    function getEditProf($id){
        try{
            
            $sql = 'SELECT `name` , `profile` , pic ,html_flg , css_flg ,
                            js_jq_flg , sql_flg , java_flg , p.php_flg , php_oj_flg , 
                            php_fw_flg , ruby_flg , rails_flg , laravel_flg , 
                            swift_flg , scala_flg , go_flg , kotolin_flg ,
                                `year` , `month` , engineer_history , work_flg
                    FROM users AS u LEFT JOIN profiles AS p ON u.id = p.user_id
                    WHERE u.id = :id';

            $data = array('id' => $id );

            $dbUserData = DB::select($sql,$data);

            return $dbUserData;

        } catch (Exception $e){
            $errors->common = 'しばらく経ってから処理を行ってください';
        }
    }

    public function upDateProf($data){
        try{
            
            $sql = 'UPDATE `users` INNER JOIN profiles ON users.id = profiles.user_id
                    SET `name` = :name , `profile` = :profile , pic = :pic , html_flg = :html_flg ,
                        css_flg = :css_flg , js_jq_flg = :js_jq_flg , sql_flg = :sql_flg ,
                        java_flg = :java_flg , php_flg = :php_flg , php_oj_flg = :php_oj_flg , 
                        php_fw_flg = :php_fw_flg , ruby_flg = :ruby_flg , rails_flg = :rails_flg ,
                        laravel_flg = :laravel_flg , swift_flg = :swift_flg , scala_flg = :scala_flg ,
                        go_flg = :go_flg , kotolin_flg = :kotolin_flg , `year` = :year ,
                        `month` = :month , engineer_history = :engineer_history ,work_flg = :work_flg
                    WHERE users.id = :id';

            //dd($sql,$data);
            DB::update($sql,$data);

        }catch (Exception $e) { 
            $errors->common = 'しばらく経ってから処理を行ってください';
        }
    }

}
