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
        $rules = [
            'name' => ['required', 'string', 'max:20'],
            'icon' => ['required','image','mimes:jpeg,jpg,png','max:2048'],
            'post_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255']
        ];
        
        if ($this->isMethod('post')){
            $rules['icon'] = [
                'required','image','mimes:jpeg,jpg,png','max:2048'
            ];
        }

        if ($this->isMethod('patch')){
            $rules['icon'] = [
                'nullable','image','mimes:jpeg,jpg,png','max:2048'
            ];
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'icon.required' => 'プロフィール画像を登録してください',
            'icon.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => 'ハイフンありの8文字で入力してください(例：000-0000)',
            'address.required' => '住所を入力してください',
        ];
    }
}
