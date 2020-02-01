<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public static $rules = [
        'name' => ['required','max:255'],
        'profile' => ['string','min:6','max:255'],
        'pic' => ['file','image','mimes:jpeg,png,jpg,gif','max:2048'],
        'year' => ['numeric'],
        'month' => ['numeric']
    ];
}
