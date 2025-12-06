@extends('admin.layouts.app')

@section('title')
    Sản phẩm
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
                            <h4 class="mb-0 fw-bold">Sản phẩm</h4>
                            <small class="text-muted">
                                <i class="fas fa-boxes me-1"></i>
                                Tổng số: <span class="fw-semibold">{{$products->count()}}</span> sản phẩm
                            </small>
                        </div>
                        <a href="{{route('admin.products.create')}}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Thêm mới
                        </a>
                    </div>
                </div>

                <!-- Products Table Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 no-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 text-center" style="width: 4%;">#</th>
                                        <th class="border-0" style="width: 8%;">Ảnh</th>
                                        <th class="border-0" style="width: 22%;">Tên sản phẩm</th>
                                        <th class="border-0" style="width: 12%;">Bộ sưu tập</th>
                                        <th class="border-0 text-center" style="width: 10%;">Loại</th>
                                        <th class="border-0 text-center" style="width: 8%;">SL</th>
                                        <th class="border-0 text-end" style="width: 12%;">Giá</th>
                                        <th class="border-0 text-center" style="width: 12%;">Trạng thái</th>
                                        <th class="border-0 text-center" style="width: 12%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $key => $product)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{$key + 1}}</td>
                                            <td>
                                                <img src="{{asset($product->thumbnail)}}"
                                                     alt="{{$product->product_name}}"
                                                     class="rounded border"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-dark">{{$product->product_name}}</span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-cube me-1" style="font-size: 0.7rem;"></i>
                                                        {{$product->material}}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($product->collection)
                                                    <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">
                                                        {{$product->collection->collection_name}}
                                                    </span>
                                                @else
                                                    <span class="text-muted" style="font-size: 0.75rem;">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary" style="font-size: 0.7rem;">
                                                    {{$product->shape}}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($product->product_qty > 10)
                                                    <span class="badge bg-success">{{$product->product_qty}}</span>
                                                @elseif($product->product_qty > 0)
                                                    <span class="badge bg-warning text-dark">{{$product->product_qty}}</span>
                                                @else
                                                    <span class="badge bg-danger">0</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold text-danger">{{number_format($product->product_price, 0, ',', '.')}} ₫</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($product->status)
                                                    <span class="badge bg-success" style="font-size: 0.7rem;">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Đang bán
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger" style="font-size: 0.7rem;">
                                                        <i class="fas fa-pause-circle me-1"></i>
                                                        Tạm ngưng
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('admin.products.edit', $product->slug)}}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#"
                                                       onclick="deleteItem({{$product->product_id}}); return false;"
                                                       class="btn btn-sm btn-outline-danger"
                                                       title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                                <form id="{{$product->product_id}}"
                                                      action="{{route('admin.products.destroy', $product->slug)}}"
                                                      method="post"
                                                      class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <i class="fas fa-boxes fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted mb-0">Chưa có sản phẩm nào</p>
                                                <small class="text-muted">Hãy tạo sản phẩm đầu tiên</small>
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
@endsection
