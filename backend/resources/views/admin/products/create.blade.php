@extends('admin.layouts.app')

@section('title')
    Thêm sản phẩm
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
                                <h4 class="mb-0 fw-bold">Thêm sản phẩm mới</h4>
                                <small class="text-muted">Điền thông tin để tạo sản phẩm</small>
                            </div>
                            <a href="{{route('admin.products.index')}}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">-4">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <form action="{{route('admin.products.store')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <!-- Thông tin cơ bản -->
                                <h5 class="fw-bold mb-3 pb-2 border-bottom">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Thông tin cơ bản
                                </h5>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-floating mb-3">g mb-3">
                                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" placeholder="Tên sản phẩm"
                                            value="{{old('product_name')}}">
                                            <label for="product_name">Tên sản phẩm*</label>
                                            @error('product_name')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">g mb-3">
                                            <input type="number" class="form-control @error('released_at') is-invalid @enderror" id="released_at" name="released_at" placeholder="Năm ra mắt"
                                            value="{{old('released_at')}}">
                                            <label for="released_at">Năm ra mắt*</label>
                                            @error('released_at')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-control @error('collection_id') is-invalid @enderror" id="collection_id" name="collection_id">
                                        <option value="">Chọn BST</option>
                                        @foreach($collections as $collection)
                                            <option value="{{ $collection->collection_id }}" {{ old('collection_id') == $collection->collection_id ? 'selected' : '' }}>
                                                {{ $collection->collection_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="collection_id">Bộ sưu tập*</label>
                                    @error('collection_id')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">g mb-3">
                                            <input type="number" class="form-control @error('product_qty') is-invalid @enderror" id="product_qty" name="product_qty" placeholder="Số lượng"
                                            value="{{old('product_qty')}}">
                                            <label for="product_qty">Số lượng*</label>
                                            @error('product_qty')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">g mb-3">
                                            <input type="number" class="form-control @error('product_price') is-invalid @enderror" id="product_price" name="product_price" placeholder="Giá sản phẩm"
                                            value="{{old('product_price')}}">
                                            <label for="product_price">Giá bán*</label>
                                            @error('product_price')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Thông số kỹ thuật -->
                                <h5 class="fw-bold mb-3 pb-2 border-bottom mt-4">
                                    <i class="fas fa-cog me-2 text-primary"></i>Thông số kỹ thuật
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">="mb-3">
                                            <label for="shape" class="form-label">Loại dáng*</label>
                                            <select name="shape" id="shape" class="form-select @error('shape') is-invalid @enderror">
                                                <option value="Vuông" {{ old('shape') == 'Vuông' ? 'selected' : '' }}>Vuông</option>
                                                <option value="Oval" {{ old('shape') == 'Oval' ? 'selected' : '' }}>Oval</option>
                                                <option value="Tròn" {{ old('shape') == 'Tròn' ? 'selected' : '' }}>Tròn</option>
                                                <option value="Cat-eye" {{ old('shape') == 'Cat-eye' ? 'selected' : '' }}>Cat-eye</option>
                                                <option value="Wraparound" {{ old('shape') == 'Wraparound' ? 'selected' : '' }}>Wraparound</option>
                                                <option value="Aviator" {{ old('shape') == 'Aviator' ? 'selected' : '' }}>Aviator</option>
                                            </select>
                                            @error('shape')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">="mb-3">
                                            <label for="material" class="form-label">Chất liệu*</label>
                                            <select name="material" id="material" class="form-select @error('material') is-invalid @enderror">
                                                <option value="Acetate" {{ old('material') == 'Acetate' ? 'selected' : '' }}>Acetate</option>
                                                <option value="Nylon" {{ old('material') == 'Nylon' ? 'selected' : '' }}>Nylon</option>
                                                <option value="Kim loại" {{ old('material') == 'Kim loại' ? 'selected' : '' }}>Kim loại</option>
                                                <option value="Mixed" {{ old('material') == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                                            </select>
                                            @error('material')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Mô tả sản phẩm -->
                                <h5 class="fw-bold mb-3 pb-2 border-bottom mt-4">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Mô tả sản phẩm
                                </h5>

                                <div class="mb-3">
                                    <label for="product_desc" class="form-label">Mô tả chi tiết*</label>ô tả chi tiết*</label>
                                    <textarea rows="6" class="form-control @error('product_desc') is-invalid @enderror" id="product_desc" name="product_desc" placeholder="Nhập mô tả chi tiết về sản phẩm...">{{old('product_desc')}}</textarea>
                                    @error('product_desc')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Hình ảnh sản phẩm -->
                                <h5 class="fw-bold mb-3 pb-2 border-bottom mt-4">
                                    <i class="fas fa-images me-2 text-primary"></i>Hình ảnh sản phẩm
                                </h5>

                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Ảnh chính*</label>
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                                    @error('thumbnail')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                    <div class="mt-2">
                                        <img src="#" alt="" id="thumbnail_preview" class="d-none rounded border" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_img" class="form-label">Ảnh phụ 1</label>
                                        <input type="file" class="form-control @error('first_img') is-invalid @enderror" id="first_img" name="first_img" accept="image/*">
                                        @error('first_img')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                        <div class="mt-2">
                                            <img src="#" alt="" id="first_img_preview" class="d-none rounded border" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="second_img" class="form-label">Ảnh phụ 2</label>
                                        <input type="file" class="form-control @error('second_img') is-invalid @enderror" id="second_img" name="second_img" accept="image/*">
                                        @error('second_img')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                        <div class="mt-2">
                                            <img src="#" alt="" id="second_img_preview" class="d-none rounded border" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="third_img" class="form-label">Ảnh phụ 3</label>
                                        <input type="file" class="form-control @error('third_img') is-invalid @enderror" id="third_img" name="third_img" accept="image/*">
                                        @error('third_img')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                        <div class="mt-2">
                                            <img src="#" alt="" id="third_img_preview" class="d-none rounded border" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fourth_img" class="form-label">Ảnh phụ 4</label>
                                        <input type="file" class="form-control @error('fourth_img') is-invalid @enderror" id="fourth_img" name="fourth_img" accept="image/*">
                                        @error('fourth_img')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                        <div class="mt-2">
                                            <img src="#" alt="" id="fourth_img_preview" class="d-none rounded border" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top"> justify-content-between align-items-center pt-3 border-top">
                                    <a href="{{route('admin.products.index')}}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Hủy
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Tạo sản phẩm
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
