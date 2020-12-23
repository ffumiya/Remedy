<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSurveyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'comment' => 'max:300'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前が入力されていません。',
            'comment.max'  => '質問内容は :max 文字以下で入力してください。',
        ];
    }
}
