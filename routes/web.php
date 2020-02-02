<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    return view('entry.index');
});

//login,register等のauth関係のルート php artisan route:listで確認可能
Auth::routes();

//larabelのトップページへのルート　※不使用だがauthをインストールしたら自動的に追加された
Route::get('/home', 'HomeController@index')->name('home');

//profileへのルート(編集用)
Route::get('profile/{user_id?}','profileController@showProfile');

//profileへのルート(検索時のポスト送信)
Route::post('profile/{user_id?}','profileController@showProfile');

//profileへのルート(getパラメータ有り)
//Route::get('profile/{user_id}','profileController@showProfile');

//proEditへのルート
Route::get('/profEdit','profEditController@getProfile');

//proEditでのプロフィール登録・更新
Route::post('/profEdit','profEditController@registerProfile');

//outputRegistでアウトプットの登録
Route::get('/outputRegist','OpRegistController@registerOutput');

//outputEditでアウトプットの新規保存
Route::post('/outputSave','OpRegistController@saveOutput');

//outputEditで登録済のアウトプットを取得
Route::get('/outputEdit/{op_id}','OpRegistController@getOutput');

//outputEditでアウトプットの更新
Route::post('/outputUpdate/{op_id}','OpRegistController@updateOutput');

//outputListへのルート
Route::get('/outputList','OpListController@showList');

//outputListへのルート
Route::post('/outputList','OpListController@showList');

//ログアウトのルート
Route::get('/logout','Auth\LoginController@logout');

//Vue　サンプルのルート
Route::get('/sample', function () {
    return view('sample');
});