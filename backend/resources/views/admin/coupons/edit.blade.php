@extends('admin.layouts.app')

@section('title')
    Cập nhật mã giảm giá
@endsection

@section('content')
<div class="row">
    @include('admin.layouts.sidebar')
    <div class="col-md-9">
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card-header bg-white">
                    <h3 class="mt-2">Cập nhật mã giảm giá</h3>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <form action="{{route('admin.coupons.update', $coupon->coupon_id)}}" method="post">
                                @csrf
                                @method("PUT")

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('coupon_name') is-invalid @enderror" id="coupon_name" name="coupon_name" placeholder="Tên mã giảm giá"
                                    value="{{old('coupon_name', $coupon->coupon_name)}}">
                                    <label for="coupon_name">Tên mã giảm giá*</label>
                                    @error('coupon_name')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" placeholder="Discount"
                                    value="{{old('discount', $coupon->discount)}}">
                                    <label for="discount">Phần trăm giảm*</label>
                                    @error('discount')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" step="0.01" class="form-control @error('min_total') is-invalid @enderror" id="min_total" name="min_total" placeholder="Giá trị đơn hàng tối thiểu"
                                    value="{{old('min_total', $coupon->min_total)}}">
                                    <label for="min_total">Giá trị đơn hàng tối thiểu*</label>
                                    @error('min_total')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="datetime-local" class="form-control @error('valid_until') is-invalid @enderror" id="valid_until" name="valid_until" placeholder="Validity"
                                    value="{{old('valid_until', $coupon->valid_until)}}">
                                    <label for="valid_until">Hiệu lực*</label>
                                    @error('valid_until')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <button type="submit" class="btn btn-sm btn-dark">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
