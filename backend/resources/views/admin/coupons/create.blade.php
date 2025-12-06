@extends('admin.layouts.app')

@section('title')
    Thêm mã giảm giá
@endsection

@section('content')
<div class="row">
    @include('admin.layouts.sidebar')
    <div class="col-md-9">
        <div class="row mt-2">
            <div class="col-md-12">
                <!-- Header Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 fw-bold">Thêm mã giảm giá mới</h4>
                                <small class="text-muted">Điền thông tin để tạo mã giảm giá</small>
                            </div>
                            <a href="{{route('admin.coupons.index')}}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-7 mx-auto">
                                <form action="{{route('admin.coupons.store')}}" method="post">
                                    @csrf

                                    <!-- Thông tin mã giảm giá -->
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">
                                        <i class="fas fa-tag me-2 text-primary"></i>Thông tin mã giảm giá
                                    </h5>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('coupon_name') is-invalid @enderror" id="coupon_name" name="coupon_name" placeholder="Tên mã giảm giá"
                                        value="{{old('coupon_name')}}">
                                        <label for="coupon_name">Mã giảm giá*</label>
                                        @error('coupon_name')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" placeholder="Phần trăm giảm" min="1" max="100"
                                                value="{{old('discount')}}">
                                                <label for="discount">Phần trăm giảm (%)*</label>
                                                @error('discount')
                                                    <span class="invalid-feedback">
                                                        <strong>{{$message}}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" step="0.01" class="form-control @error('min_total') is-invalid @enderror" id="min_total" name="min_total" placeholder="Giá trị đơn hàng tối thiểu"
                                                value="{{old('min_total')}}">
                                                <label for="min_total">Giá trị tối thiểu (đ)*</label>
                                                @error('min_total')
                                                    <span class="invalid-feedback">
                                                        <strong>{{$message}}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Thời gian hiệu lực -->
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom mt-4">
                                        <i class="fas fa-clock me-2 text-primary"></i>Thời gian hiệu lực
                                    </h5>

                                    <div class="form-floating mb-4">
                                        <input type="datetime-local" class="form-control @error('valid_until') is-invalid @enderror" id="valid_until" name="valid_until" placeholder="Hiệu lực" min="{{\Carbon\Carbon::now()->addDays(1)->format('Y-m-d\TH:i')}}"
                                        value="{{old('valid_until', \Carbon\Carbon::now()->format('Y-m-d\TH:i'))}}">
                                        <label for="valid_until">Hiệu lực đến*</label>
                                        @error('valid_until')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <a href="{{route('admin.coupons.index')}}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hủy
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Tạo mã giảm giá
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
