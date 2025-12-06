@extends('admin.layouts.app')

@section('title')
    Cập nhật Bộ sưu tập
@endsection

@section('content')
@include('admin.layouts.sidebar')
<div class="col-md-9">
    <div class="row mt-2">
            <div class="col-md-12">
                <!-- Header Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 fw-bold">Cập nhật Bộ sưu tập</h4>
                                <small class="text-muted">Chỉnh sửa thông tin bộ sưu tập</small>
                            </div>
                            <a href="{{route('admin.collections.index')}}" class="btn btn-outline-secondary">
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
                                <form action="{{route('admin.collections.update', $collection->slug)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Thông tin cơ bản -->
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>Thông tin cơ bản
                                    </h5>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('collection_name') is-invalid @enderror" id="collection_name" name="collection_name" placeholder="Tên Bộ sưu tập"
                                        value="{{old('collection_name', $collection->collection_name)}}">
                                        <label for="collection_name">Tên Bộ sưu tập*</label>
                                        @error('collection_name')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control @error('released') is-invalid @enderror" id="released" name="released" placeholder="Năm phát hành"
                                        value="{{old('released', $collection->released)}}">
                                        <label for="released">Năm ra mắt*</label>
                                        @error('released')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="collection_desc" class="form-label">Mô tả Bộ sưu tập*</label>
                                        <textarea rows="6" class="form-control @error('collection_desc') is-invalid @enderror" id="collection_desc" name="collection_desc" placeholder="Nhập mô tả về bộ sưu tập...">{{old('collection_desc', $collection->collection_desc)}}</textarea>
                                        @error('collection_desc')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Hình ảnh -->
                                    <h5 class="fw-bold mb-3 pb-2 border-bottom mt-4">
                                        <i class="fas fa-image me-2 text-primary"></i>Hình ảnh Banner
                                    </h5>

                                    <div class="mb-4">
                                        <label for="banner_img" class="form-label">Ảnh Banner*</label>
                                        <input type="file" class="form-control @error('banner_img') is-invalid @enderror" id="banner_img" name="banner_img" accept="image/*">
                                        @error('banner_img')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                        <div class="mt-2">
                                            <img src="{{asset($collection->banner_img)}}" alt="Current" class="rounded border me-2" style="max-width: 300px; max-height: 200px;">
                                            <img src="#" alt="" id="banner_img_preview" class="d-none rounded border" style="max-width: 300px; max-height: 200px;">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <a href="{{route('admin.collections.index')}}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>Hủy
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Cập nhật bộ sưu tập
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
