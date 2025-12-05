<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'coupon_name' => 'required|max:20|unique:coupons,coupon_name,' . $this->route('coupon')->coupon_id . ',coupon_id',
            'discount' => 'required|integer|min:0|max:100',
            'min_total' => 'required|numeric|min:0',
            'valid_until' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'coupon_name.required' => 'Tên mã giảm giá là bắt buộc.',
            'coupon_name.max' => 'Tên mã giảm giá không được vượt quá 20 ký tự.',
            'coupon_name.unique' => 'Tên mã giảm giá đã tồn tại.',
            'discount.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount.integer' => 'Giá trị giảm giá phải là số nguyên.',
            'discount.min' => 'Giá trị giảm giá phải ít nhất là 0.',
            'discount.max' => 'Giá trị giảm giá không được vượt quá 100.',
            'min_total.required' => 'Giá trị đơn hàng tối thiểu là bắt buộc.',
            'min_total.numeric' => 'Giá trị đơn hàng tối thiểu phải là số.',
            'min_total.min' => 'Giá trị đơn hàng tối thiểu không được nhỏ hơn 0.',
            'valid_until.required' => 'Ngày hết hạn là bắt buộc.',
            'valid_until.date' => 'Ngày hết hạn không hợp lệ.',
        ];
    }
}
