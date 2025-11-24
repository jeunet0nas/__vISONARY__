<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthAdminRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255'
        ];
    }

    public function messages(): array {
        return [
            'email.required' => 'Bạn phải nhập email.',
            'email.email'    => 'Email không đúng định dạng.',
            'email.max'      => 'Email không được vượt quá 255 ký tự.',

            'password.required' => 'Bạn phải nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.max'      => 'Mật khẩu không được vượt quá 255 ký tự.',
        ];
    }
}
