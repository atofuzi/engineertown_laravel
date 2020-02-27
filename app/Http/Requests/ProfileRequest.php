<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  [
        'name' => ['required','min:6','max:255'],
        'profile' => ['string','max:255'],
        'pic' => ['file','image','mimes:jpeg,png,jpg,gif','max:2048'],
        'year' => ['numeric'],
        'month' => ['numeric'],
        'engineer_history' => ['numeric']
        ];
    }

        
}