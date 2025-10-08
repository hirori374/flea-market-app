<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required','integer','min:0'],
            'condition' => ['required'],
            'category' => ['required','array'],
            'image' => ['required','image','mimes:jpeg,jpg,png','max:2048'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '商品価格を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0円以上で入力してください',
            'condition.required' => '商品の状態を選択してください',
            'category.required' => 'カテゴリーは1つ以上選択してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '255文字以内で入力してください',
        ];
    }
}
