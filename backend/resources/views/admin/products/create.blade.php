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
                <div class="card-header bg-white">
                    <h3 class="mt-2">Thêm sản phẩm mới</h3>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <form action="{{route('admin.products.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="floatingInput" name="product_name" placeholder="Tên sản phẩm mới"
                                    value="{{old('product_name')}}">
                                    <label for="floatingInput">Tên sản phẩm*</label>
                                    @error('product_name')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-control @error('collection_id') is-invalid @enderror" id="floatingSelect" name="collection_id">
                                        <option value="">Chọn BST</option>
                                        @foreach($collections as $collection)
                                            <option value="{{ $collection->collection_id }}" {{ old('collection_id') == $collection->collection_id ? 'selected' : '' }}>
                                                {{ $collection->collection_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">BST*</label>
                                    @error('collection_id')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('product_qty') is-invalid @enderror" id="floatingInput" name="product_qty" placeholder="Số lượng"
                                    value="{{old('product_qty')}}">
                                    <label for="floatingInput">Số lượng*</label>
                                    @error('product_qty')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('product_price') is-invalid @enderror" id="floatingInput" name="product_price" placeholder="Giá sản phẩm"
                                    value="{{old('product_price')}}">
                                    <label for="floatingInput">Giá*</label>
                                    @error('product_price')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="shape" class="my-2">Loại*</label>
                                    <select name="shape" id="shape" class="form-control @error('shape') is-invalid @enderror">
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

                                <div class="mb-3">
                                    <label for="material" class="my-2">Chất liệu*</label>
                                    <select name="material" id="material" class="form-control @error('material') is-invalid @enderror">
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

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('released_at') is-invalid @enderror" id="floatingInput" name="released_at" placeholder="Năm ra mắt"
                                    value="{{old('released_at')}}">
                                    <label for="floatingInput">Năm ra mắt*</label>
                                    @error('released_at')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label for="color_id" class="form-label">Màu*</label>
                                <select name="color_id[]" id="color_id" multiple
                                    class="form-control @error('color_id') is-invalid @enderror">
                                    <option value="" disabled>Chọn màu</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->color_id }}"
                                            @if(collect(old('color_id'))->contains($color->color_id)) selected @endif>
                                            {{ $color->color_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('color_id')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                                <div class="mb-3">
                                    <label for="product_desc">Mô tả chung*</label>
                                    <textarea rows="10" class="form-control @error('product_desc') is-invalid @enderror" id="product_desc" name="product_desc" placeholder="Mô tả sản phẩm">
                                        {{old('product_desc')}}
                                    </textarea>
                                    @error('product_desc')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="thumbnail">Ảnh chính*</label>
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
                                    @error('thumbnail')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <img src="#" alt="" id="thumbnail_preview" class="d-none img-fluid mb-2" height="100" width="100">
                                </div>

                                <div class="mb-3">
                                    <label for="first_img">Ảnh phụ thứ 1</label>
                                    <input type="file" class="form-control @error('first_img') is-invalid @enderror" id="first_img" name="first_img">
                                    @error('first_img')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <img src="#" alt="" id="first_img_preview" class="d-none img-fluid mb-2" height="100" width="100">
                                </div>

                                <div class="mb-3">
                                    <label for="second_img">Ảnh phụ thứ 2</label>
                                    <input type="file" class="form-control @error('second_img') is-invalid @enderror" id="second_img" name="second_img">
                                    @error('second_img')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <img src="#" alt="" id="second_img_preview" class="d-none img-fluid mb-2" height="100" width="100">
                                </div>

                                <div class="mb-3">
                                    <label for="third_img">Ảnh phụ thứ 3</label>
                                    <input type="file" class="form-control @error('third_img') is-invalid @enderror" id="third_img" name="third_img">
                                    @error('third_img')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <img src="#" alt="" id="third_img_preview" class="d-none img-fluid mb-2" height="100" width="100">
                                </div>

                                <div class="mb-3">
                                    <label for="fourth_img">Ảnh phụ thứ 4</label>
                                    <input type="file" class="form-control @error('fourth_img') is-invalid @enderror" id="fourth_img" name="fourth_img">
                                    @error('fourth_img')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <img src="#" alt="" id="fourth_img_preview" class="d-none img-fluid mb-2" height="100" width="100">
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
