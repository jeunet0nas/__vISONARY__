@extends('admin.layouts.app')

@section('title')
    Người dùng
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
                                <h4 class="mb-0 fw-bold">Người dùng</h4>
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    Tổng số: <span class="fw-semibold">{{$users->count()}}</span> thành viên
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 no-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 text-center" style="width: 5%;">#</th>
                                        <th class="border-0" style="width: 30%;">Tên khách hàng</th>
                                        <th class="border-0" style="width: 30%;">Email</th>
                                        <th class="border-0 text-center" style="width: 25%;">Ngày đăng ký</th>
                                        <th class="border-0 text-center" style="width: 10%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key => $user)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{$key + 1}}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <span class="fw-semibold text-dark">{{$user->customer_name}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <i class="fas fa-envelope me-2" style="font-size: 0.7rem;"></i>
                                                    {{$user->email}}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-column">
                                                    <small class="text-muted">{{$user->created_at->format('d/m/Y H:i')}}</small>
                                                    <small class="text-primary fw-semibold">{{$user->created_at->diffForHumans()}}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="#"
                                                   onclick="deleteItem({{$user->customer_id}}); return false;"
                                                   class="btn btn-sm btn-outline-danger"
                                                   title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form id="{{$user->customer_id}}"
                                                      action="{{route('admin.users.delete', $user->customer_id)}}"
                                                      method="post"
                                                      class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                                                <p class="text-muted mb-0">Chưa có người dùng nào</p>
                                                <small class="text-muted">Người dùng sẽ xuất hiện sau khi đăng ký</small>
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
