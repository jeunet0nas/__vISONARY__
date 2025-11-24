<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColorRequest extends FormRequest
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
            'color_name' => 'required|max:20|unique:colors,color_name, '. $this->route('color')->color_id . ',color_id'
        ];
    }

    public function messages(): array
    {
        return [
            'color_name.required' => 'Tên màu là bắt buộc.',
            'color_name.max'      => 'Tên màu không được vượt quá 20 ký tự.',
            'color_name.unique'   => 'Tên màu này đã tồn tại, vui lòng chọn tên khác.'
        ];
    }
}
