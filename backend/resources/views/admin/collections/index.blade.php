@extends('admin.layouts.app')

@section('title')
    Bộ sưu tập
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
                            <h4 class="mb-0 fw-bold">Bộ sưu tập</h4>
                            <small class="text-muted">
                                <i class="fas fa-layer-group me-1"></i>
                                Tổng số: <span class="fw-semibold">{{$collections->count()}}</span> bộ sưu tập
                            </small>
                        </div>
                        <a href="{{route('admin.collections.create')}}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Thêm mới
                        </a>
                    </div>
                </div>

                <!-- Collections Table Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 no-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 text-center" style="width: 5%;">#</th>
                                        <th class="border-0" style="width: 15%;">Ảnh</th>
                                        <th class="border-0" style="width: 35%;">Tên bộ sưu tập</th>
                                        <th class="border-0" style="width: 15%;">Năm phát hành</th>
                                        <th class="border-0" style="width: 20%;">Mô tả</th>
                                        <th class="border-0 text-center" style="width: 10%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($collections as $key => $collection)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{$key + 1}}</td>
                                            <td>
                                                <img src="{{asset($collection->banner_img)}}"
                                                     alt="{{$collection->collection_name}}"
                                                     class="rounded border"
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-dark">{{$collection->collection_name}}</div>
                                                <small class="text-muted">
                                                    <i class="fas fa-link me-1" style="font-size: 0.7rem;"></i>
                                                    {{$collection->slug}}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">{{$collection->released}}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                    {{$collection->collection_desc}}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('admin.collections.edit', $collection->slug)}}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#"
                                                       onclick="deleteItem({{$collection->collection_id}}); return false;"
                                                       class="btn btn-sm btn-outline-danger"
                                                       title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                                <form id="{{$collection->collection_id}}"
                                                      action="{{route('admin.collections.destroy', $collection->slug)}}"
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
                                                <i class="fas fa-layer-group fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted mb-0">Chưa có bộ sưu tập nào</p>
                                                <small class="text-muted">Hãy tạo bộ sưu tập đầu tiên</small>
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
