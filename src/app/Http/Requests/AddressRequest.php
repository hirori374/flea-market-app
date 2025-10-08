<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        return [
            'delivery_post_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'delivery_address' => ['required', 'string', 'max:255'],
            'delivery_building' => ['string', 'max:255']
        ];
    }
    public function messages()
    {
        return [
            'delivery_post_code.required' => '郵便番号を入力してください',
            'delivery_post_code.regex' => 'ハイフンありで入力してください(例：000-0000)',
            'delivery_address.required' => '住所を入力してください',
        ];
    }
}
