<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    protected $fillable = [ 'op_name',
                            'explanation',
                            'html_flg',
                            'css_flg',
                            'js_jq_flg',
                            'sql_flg',
                            'java_flg',
                            'php_flg',
                            'php_oj_flg',
                            'php_fw_flg',
                            'ruby_flg',
                            'rails_flg',
                            'laravel_flg',
                            'swift_flg',
                            'scala_flg',
                            'go_flg',
                            'kotolin_flg',
                            ];

    public static $rules = [
        'op_name' => ['required','max:30'],
        'explanation' => ['required','max:255'],
        'pic_main' => ['required','file','image','mimes:jpeg,png,jpg,gif','max:3072'],
        'pic_sub1' => ['file','image','mimes:jpeg,png,jpg,gif','max:3072'],
        'pic_sub2' => ['file','image','mimes:jpeg,png,jpg,gif','max:3072'],
        'movie' => ['file','mimes:mp4','max:20480'],
    ];

    public static $rules_noFile = [
        'op_name' => ['required','max:30'],
        'explanation' => ['required','max:255'],
    ];


    
}
