@extends('admin.layouts.app')

@section('title')
    Hóa đơn
@endsection

@section('content')
<div class="row">
    @include('admin.layouts.sidebar')
    <div class="col-md-9">
        <div class="row mt-2">
            <div class="col-md-12">
                <!-- Header Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold">Quản lý đơn hàng</h4>
                            <small class="text-muted">
                                <i class="fas fa-receipt me-1"></i>
                                Tổng số: <span class="fw-semibold">{{$orders->count()}}</span> đơn hàng
                            </small>
                        </div>
                        <div>
                            <span class="badge bg-primary fs-6">
                                <i class="fas fa-chart-line me-1"></i>
                                {{number_format($orders->sum('grand_total'), 0, ',', '.')}} ₫
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Search Filter Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted mb-3 fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            <i class="fas fa-filter me-2"></i>Lọc theo thời gian
                        </h6>
                        <form method="GET" action="{{ route('admin.orders.index') }}">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label for="start_date" class="form-label small text-muted mb-1">Từ ngày</label>
                                    <input type="date" name="start_date" id="start_date"
                                           class="form-control form-control-sm"
                                           value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="end_date" class="form-label small text-muted mb-1">Đến ngày</label>
                                    <input type="date" name="end_date" id="end_date"
                                           class="form-control form-control-sm"
                                           value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                        <i class="fas fa-search me-1"></i>Tìm
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Có lỗi xảy ra:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Success Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Orders Table Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 no-datatables" id="ordersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 text-center" style="width: 5%;">#</th>
                                        <th class="border-0" style="width: 20%;">Khách hàng</th>
                                        <th class="border-0 text-end" style="width: 15%;">Tổng tiền</th>
                                        <th class="border-0 text-center" style="width: 12%;">Giảm giá</th>
                                        <th class="border-0" style="width: 13%;">Ngày đặt</th>
                                        <th class="border-0 text-center" style="width: 13%;">Trạng thái</th>
                                        <th class="border-0 text-center" style="width: 7%;" data-orderable="false"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $key => $order)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{$key + 1}}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-dark">{{$order->customer->customer_name ?? 'N/A'}}</span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-phone me-1" style="font-size: 0.7rem;"></i>
                                                        {{$order->order_phone ?? 'N/A'}}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column align-items-end">
                                                    <span class="fw-bold text-danger">{{number_format($order->grand_total ?? 0, 0, ',', '.')}} ₫</span>
                                                    @if (($order->discount_amount ?? 0) > 0)
                                                        <small class="text-muted text-decoration-line-through">
                                                            {{number_format($order->subtotal ?? 0, 0, ',', '.')}} ₫
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($order->coupon)
                                                    <span class="badge bg-success" style="font-size: 0.7rem;">
                                                        <i class="fas fa-tag me-1"></i>
                                                        {{$order->coupon->coupon_name}}
                                                        <br>
                                                        <small>-{{$order->coupon->discount}}%</small>
                                                    </span>
                                                @else
                                                    <span class="text-muted" style="font-size: 0.75rem;">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{$order->created_at ? $order->created_at->format('d/m/Y') : 'N/A'}}
                                                    <br>
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{$order->created_at ? $order->created_at->format('H:i') : 'N/A'}}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                @if ($order->delivered_at)
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="badge bg-success mb-1" style="font-size: 0.7rem;">
                                                            <i class="fas fa-check-circle me-1"></i>
                                                            Đã giao
                                                        </span>
                                                        <small class="text-muted" style="font-size: 0.65rem;">
                                                            {{\Carbon\Carbon::parse($order->delivered_at)->diffForHumans()}}
                                                        </small>
                                                    </div>
                                                @else
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="badge bg-warning text-dark mb-1" style="font-size: 0.7rem;">
                                                            <i class="fas fa-clock me-1"></i>
                                                            Chờ xử lý
                                                        </span>
                                                        <a href="{{route('admin.orders.update', $order->order_id)}}"
                                                           class="btn btn-sm btn-outline-success"
                                                           style="font-size: 0.7rem; padding: 0.15rem 0.4rem;"
                                                           title="Xác nhận đã giao">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button"
                                                            data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.orders.show', $order->order_id) }}">
                                                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                                                            </a>
                                                        </li>
                                                        @if (!$order->delivered_at)
                                                            <li>
                                                                <a class="dropdown-item" href="{{route('admin.orders.update', $order->order_id)}}">
                                                                    <i class="fas fa-check me-2"></i>Xác nhận giao
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger"
                                                               href="#"
                                                               onclick="deleteItem({{$order->order_id}}); return false;">
                                                                <i class="fas fa-trash me-2"></i>Xóa đơn
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <form id="{{$order->order_id}}"
                                                      action="{{route('admin.orders.delete', $order->order_id)}}"
                                                      method="post"
                                                      class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted mb-0">Chưa có đơn hàng nào</p>
                                                <small class="text-muted">Các đơn hàng sẽ xuất hiện ở đây khi có khách đặt hàng</small>
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
</div>

<script>
function deleteItem(id) {
    if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
        document.getElementById(id).submit();
    }
}
</script>
@endsection
