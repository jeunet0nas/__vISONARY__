<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'product_name' => 'required|max:100|min:2|unique:products,product_name',
            'product_qty' => 'required|numeric',
            'product_price' => 'required|numeric',
            'material' => 'required|max:20',
            'shape' => 'required|max:20',
            'released_at' => 'required|numeric|min:2018|max:' . date('Y'),
            'product_desc' => 'required|max:1500',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'first_img' => 'image|mimes:png,jpg,jpeg|max:5120',
            'second_img' => 'image|mimes:png,jpg,jpeg|max:5120',
            'third_img' => 'image|mimes:png,jpg,jpeg|max:5120',
            'fourth_img' => 'image|mimes:png,jpg,jpeg|max:5120',
            'collection_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 100 ký tự.',
            'product_name.min' => 'Tên sản phẩm phải có ít nhất 2 ký tự.',
            'product_name.unique' => 'Tên sản phẩm đã tồn tại trong hệ thống.',

            'product_qty.required' => 'Số lượng sản phẩm là bắt buộc.',
            'product_qty.numeric' => 'Số lượng sản phẩm phải là số.',

            'product_price.required' => 'Giá sản phẩm là bắt buộc.',
            'product_price.numeric' => 'Giá sản phẩm phải là số.',

            'material.required' => 'Chất liệu là bắt buộc.',
            'material.max' => 'Chất liệu không được vượt quá 20 ký tự.',

            'shape.required' => 'Hình dạng là bắt buộc.',
            'shape.max' => 'Hình dạng không được vượt quá 20 ký tự.',

            'released_at.required' => 'Năm phát hành là bắt buộc.',
            'released_at.numeric' => 'Năm phát hành phải là số.',
            'released_at.min' => 'Năm phát hành không được nhỏ hơn 2018.',
            'released_at.max' => 'Năm phát hành không được lớn hơn năm hiện tại.',

            'product_desc.required' => 'Mô tả sản phẩm là bắt buộc.',
            'product_desc.max' => 'Mô tả sản phẩm không được vượt quá 1500 ký tự.',

            'thumbnail.required' => 'Ảnh thumbnail là bắt buộc.',
            'thumbnail.image' => 'Thumbnail phải là một hình ảnh.',
            'thumbnail.mimes' => 'Thumbnail chỉ chấp nhận định dạng png, jpg, jpeg.',
            'thumbnail.max' => 'Dung lượng thumbnail không vượt quá 5MB.',

            'first_img.image' => 'Ảnh thứ nhất phải là hình ảnh.',
            'first_img.mimes' => 'Ảnh thứ nhất chỉ chấp nhận định dạng png, jpg, jpeg.',
            'first_img.max' => 'Dung lượng ảnh thứ nhất không vượt quá 5MB.',

            'second_img.image' => 'Ảnh thứ hai phải là hình ảnh.',
            'second_img.mimes' => 'Ảnh thứ hai chỉ chấp nhận định dạng png, jpg, jpeg.',
            'second_img.max' => 'Dung lượng ảnh thứ hai không vượt quá 5MB.',

            'third_img.image' => 'Ảnh thứ ba phải là hình ảnh.',
            'third_img.mimes' => 'Ảnh thứ ba chỉ chấp nhận định dạng png, jpg, jpeg.',
            'third_img.max' => 'Dung lượng ảnh thứ ba không vượt quá 5MB.',

            'fourth_img.image' => 'Ảnh thứ tư phải là hình ảnh.',
            'fourth_img.mimes' => 'Ảnh thứ tư chỉ chấp nhận định dạng png, jpg, jpeg.',
            'fourth_img.max' => 'Dung lượng ảnh thứ tư không vượt quá 5MB.',

            'collection_id.required' => 'Bộ sưu tập là bắt buộc.',
        ];
    }
}
