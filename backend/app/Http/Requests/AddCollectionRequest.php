<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCollectionRequest extends FormRequest
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
            'collection_name' => 'required|max:255|unique:collections',
            'released' => 'required|numeric|min:2018|max:' . date('Y'),
            'collection_desc' => 'required|max:2000',
            'banner_img' => 'required|image|mimes:png,jpg,jpeg|max:5120'
        ];
    }
    public function messages(): array
    {
        return [
            'collection_name.required' => 'Tên bộ sưu tập là bắt buộc.',
            'collection_name.max' => 'Tên bộ sưu tập không được vượt quá 255 ký tự.',
            'collection_name.unique' => 'Tên bộ sưu tập đã tồn tại, vui lòng chọn tên khác.',

            'released.required' => 'Năm phát hành là bắt buộc.',
            'released.numeric' => 'Năm phát hành phải là số.',
            'released.min' => 'Năm phát hành không được nhỏ hơn 2018.',
            'released.max' => 'Năm phát hành không được lớn hơn năm hiện tại.',

            'collection_desc.required' => 'Mô tả bộ sưu tập là bắt buộc.',
            'collection_desc.max' => 'Mô tả bộ sưu tập không được vượt quá 2000 ký tự.',

            'banner_img.required' => 'Ảnh banner là bắt buộc.',
            'banner_img.image' => 'Ảnh banner phải là một tệp hình ảnh.',
            'banner_img.mimes' => 'Ảnh banner chỉ chấp nhận định dạng: png, jpg, jpeg.',
            'banner_img.max' => 'Ảnh banner không được vượt quá 5MB.',
        ];
    }
}
