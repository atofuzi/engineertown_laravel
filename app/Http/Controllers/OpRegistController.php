<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Output;
use App\Library\MyFunc;
use DB;

class OpRegistController extends Controller{

    public function registerOutput(){
 
        return view('contents.outputRegist');

    }

    public function saveOutput(Request $req){

        $user_id = $req->session()->get('user_id');

        //入力データのバリデーションチェック
        $this->validate($req,Output::$rules);

        //pathを格納
        $path = [
            'pic_main' => MyFunc::getPath($req->pic_main),
            'pic_sub1' => MyFunc::getPath($req->pic_sub1),
            'pic_sub2' => MyFunc::getPath($req->pic_sub2),
            'movie' => MyFunc::getPath($req->movie),
        ];

        //dd($req,$path);
        
        //INSERT
        //Outputモデルのインスタンス生成
        $output =new Output();
        //user_idに値をセット
        $output->user_id = $user_id;
        //取得したファイルパスを各カラム名にセット
        foreach($path as $key => $value){
            $output->$key = $value;
        }
        //アウトプットの保存
        $output->fill($req->except('_token'))->save();

        $op_id = $output->id;

        $req->flash();
        return redirect('/outputEdit/'.$op_id);
    }

    public function getOutput(Request $req,$op_id){

        //sessionでuser_idを取得
        $user_id = $req->session()->get('user_id');

        $data = [
            'output' => Output::where('id',$op_id)->where('delete_flg','0')->first()
            ];

        if(empty($data['output'])){
                //不正にプロパティーを書き換えられた可能性有り
                //トップページへリダイレクト
        }

         return view('contents.outputEdit',$data);
    
    }

    public function updateOutput(Request $req,$op_id){

        //ファイルの変更があったかを確認するための配列を準備
        $path = ['pic_main','pic_sub1','pic_sub2','movie'];

        foreach($path as $key => $value){
            //メイン画像に変更があった場合
            if($req->has($value) && $value =='pic_main'){
                $validatedData = $req->validate([
                    $value => 'required|file|image|mimes:jpeg,png,jpg,gif|max:3072',
                ]);
            //サブ画像に変更があった場合
            }elseif($req->has($value)){
                $validatedData = $req->validate([
                    $value => 'file|image|mimes:jpeg,png,jpg,gif|max:3072',
                ]);
            }
        }

        //ファイル以外のバリデーションチェク
        $this->validate($req,Output::$rules_noFile);

        //op_idに紐づくアウトプットデータを取得
        $output = Output::find($op_id);

        //変更のあったファイルを保存・パスを取得・モデルオブジェクトに格納        
        foreach($path as $key => $value){
            if(!empty($req->has($value))){
                $path[$value] = MyFunc::getPath($req->$value);
                $output->$value = $path[$value];
            }
        }

        //UPDATE
        $output->fill($req->except('_token','_method'))->save();

        return redirect('/outputEdit/'.$op_id);

    }

}