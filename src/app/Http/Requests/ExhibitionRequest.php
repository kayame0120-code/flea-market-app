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
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'condition' => 'required|in:1,2,3,4',
            'img_url' => 'required|mimes:jpeg,png',
            'category_id'   => 'required|array',
            'category_id.*' => 'exists:categories,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください。',
            'name.string' => '商品名は文字列で入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'brand.string' => 'ブランドは文字列で入力してください。',
            'brand.max' => 'ブランドは255文字以内で入力してください。',
            'description.required' => '商品の説明を入力してください。',
            'description.string' => '商品の説明は文字列で入力してください。',
            'description.max' => '商品の説明は255文字以内で入力してください。',
            'price.required' => '価格を入力してください。',
            'price.integer' => '価格は整数で入力してください。',
            'price.min' => '価格は0以上で入力してください。',
            'condition.required' => '商品の状態を選択してください。',
            'condition.in' => '商品の状態は1,2,3,4のいずれかを選択してください。',
            'img_url.required' => '商品画像を選択してください。',
            'img_url.mimes' => '商品画像はjpegまたはpng形式のファイルを選択してください。',
            'category_id.required' => 'カテゴリーを選択してください。',
            'category_id.array' => 'カテゴリーは配列で入力してください。',
            'category_id.*.exists' => '選択されたカテゴリーが存在しません。',
        ];
    }
}
