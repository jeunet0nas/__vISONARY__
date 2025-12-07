@extends('admin.layouts.app')

@section('title')
    Mã giảm giá
@endsection

@section('content')
@include('admin.layouts.sidebar')
<div class="col-md-9">
    <div class="row mt-2">
            <div class="col-md-12">
                <!-- Header Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold">Mã giảm giá</h4>
                            <small class="text-muted">
                                <i class="fas fa-tags me-1"></i>
                                Tổng số: <span class="fw-semibold">{{$coupons->count()}}</span> mã giảm giá
                            </small>
                        </div>
                        <a href="{{route('admin.coupons.create')}}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Thêm mới
                        </a>
                    </div>
                </div>

                <!-- Coupons Table Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 no-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 text-center" style="width: 5%;">#</th>
                                        <th class="border-0" style="width: 20%;">Mã giảm giá</th>
                                        <th class="border-0 text-center" style="width: 15%;">Giảm giá</th>
                                        <th class="border-0 text-end" style="width: 20%;">Đơn tối thiểu</th>
                                        <th class="border-0" style="width: 25%;">Hiệu lực</th>
                                        <th class="border-0 text-center" style="width: 15%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($coupons as $key => $coupon)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{$key + 1}}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="badge bg-dark text-white fw-bold" style="width: fit-content; letter-spacing: 1px;">
                                                        {{$coupon->coupon_name}}
                                                    </span>
                                                    <small class="text-muted mt-1">ID: {{$coupon->coupon_id}}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-danger fs-6">
                                                    <i class="fas fa-percentage me-1"></i>
                                                    {{$coupon->discount}}%
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-semibold">{{number_format($coupon->min_total, 0, ',', '.')}} ₫</span>
                                            </td>
                                            <td>
                                                @if ($coupon->checkIfValid())
                                                    <div class="d-flex flex-column">
                                                        <span class="badge bg-success mb-1" style="width: fit-content; font-size: 0.7rem;">
                                                            <i class="fas fa-check-circle me-1"></i>
                                                            Còn hiệu lực
                                                        </span>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>
                                                            Hết hạn {{\Carbon\Carbon::parse($coupon->valid_until)->diffForHumans()}}
                                                        </small>
                                                    </div>
                                                @else
                                                    <span class="badge bg-danger" style="font-size: 0.75rem;">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        Đã hết hạn
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('admin.coupons.edit', $coupon->coupon_id)}}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#"
                                                       onclick="deleteItem({{$coupon->coupon_id}}); return false;"
                                                       class="btn btn-sm btn-outline-danger"
                                                       title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                                <form id="{{$coupon->coupon_id}}"
                                                      action="{{route('admin.coupons.destroy', $coupon->coupon_id)}}"
                                                      method="post"
                                                      class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <i class="fas fa-tags fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted mb-0">Chưa có mã giảm giá nào</p>
                                                <small class="text-muted">Hãy tạo mã giảm giá đầu tiên</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
