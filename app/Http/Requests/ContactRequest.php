<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'required|string|min:10|max:11',
            'content' => 'nullable|string',
        ];
    }

    public function message()
    {
        return [
            'name.required' => '名前は必須です。',
            'name.max' => '名前は255文字以内で入力してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'メールアドレス形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'tel.required' => '電話番号は必須です。',
            'tel,min' => '電話番号は10文字以上で入力してください。',
            'tel.max' => '電話番号は11文字以内で入力してください。',
        ];
    }
}
