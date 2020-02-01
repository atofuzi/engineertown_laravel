<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['name','email','pass','login_time'];

    public static $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:members,email',
        'pass' => 'required|string|min:6|max:255',
        'pass_re' => 'required|string|min:6|max:255|same:pass'
        
    ];
}
