@extends('admin.layouts.app')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('content')
@include('admin.layouts.sidebar')
<div class="col-md-9">
    <div class="row mt-2">
            <div class="col-md-12">
                <!-- Header -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">Đơn hàng #{{$order->order_id}}</h4>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{$order->created_at->format('d/m/Y H:i')}}
                            </small>
                        </div>
                        <div>
                            @if ($order->delivered_at)
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Đã giao
                                </span>
                            @else
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-clock me-1"></i>
                                    Đang xử lý
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Customer & Delivery Info -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-user me-2"></i>Thông tin khách hàng
                                </h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Tên khách hàng</small>
                                    <span class="fw-semibold">{{$order->customer->customer_name}}</span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Email</small>
                                    <span class="fw-semibold">{{$order->customer->email}}</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Số điện thoại</small>
                                    <span class="fw-semibold">{{$order->order_phone}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-truck me-2"></i>Thông tin giao hàng
                                </h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Địa chỉ</small>
                                    <span class="fw-semibold">{{$order->shipping_add}}</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Xác nhận giao hàng</small>
                                    @if ($order->delivered_at)
                                        <span class="text-success fw-semibold">
                                            <i class="fas fa-check-circle me-1"></i>
                                            {{\Carbon\Carbon::parse($order->delivered_at)->format('d/m/Y H:i')}}
                                        </span>
                                    @else
                                        <span class="text-warning fw-semibold">Chưa xác nhận</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            <i class="fas fa-box me-2"></i>Danh sách sản phẩm
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0" style="width: 5%;">#</th>
                                        <th class="border-0" style="width: 10%;">Hình ảnh</th>
                                        <th class="border-0" style="width: 35%;">Sản phẩm</th>
                                        <th class="border-0 text-center" style="width: 15%;">Đơn giá</th>
                                        <th class="border-0 text-center" style="width: 15%;">Số lượng</th>
                                        <th class="border-0 text-end" style="width: 20%;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->products as $key => $product)
                                        <tr>
                                            <td class="fw-semibold text-muted">{{$key + 1}}</td>
                                            <td>
                                                <img src="{{asset($product->thumbnail)}}"
                                                     alt="{{$product->product_name}}"
                                                     class="rounded border"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{$product->product_name}}</div>
                                                <small class="text-muted">PID: {{$product->product_id}}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted">{{number_format($product->pivot->item_price, 0, ',', '.')}} ₫</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">x {{$product->pivot->item_qty}}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold">{{number_format($product->pivot->item_subtotal, 0, ',', '.')}} ₫</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tạm tính:</span>
                                    <span class="fw-semibold">{{number_format($order->subtotal, 0, ',', '.')}} ₫</span>
                                </div>

                                @if ($order->coupon)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">
                                            Giảm giá
                                            <span class="badge bg-success ms-1">{{$order->coupon->coupon_name}}</span>
                                        </span>
                                        <span class="text-success fw-semibold">-{{number_format($order->discount_amount, 0, ',', '.')}} ₫</span>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Giảm giá:</span>
                                        <span class="text-muted">0 ₫</span>
                                    </div>
                                @endif

                                <hr class="my-2">

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5">Tổng cộng:</span>
                                    <span class="fw-bold fs-4 text-danger">{{number_format($order->grand_total, 0, ',', '.')}} ₫</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    @if (!$order->delivered_at)
                        <a href="{{ route('admin.orders.update', $order->order_id) }}" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Xác nhận đã giao
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
