@extends('admin.layouts.app')

@section('title')
    Thêm Bộ sưu tập
@endsection

@section('content')
<div class="row">
    @include('admin.layouts.sidebar')
    <div class="col-md-9">
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card-header bg-white">
                    <h3 class="mt-2">Thêm Bộ sưu tập mới</h3>
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <form action="{{route('admin.collections.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('collection_name') is-invalid @enderror" id="floatingInput" name="collection_name" placeholder="Tên Bộ sưu tập"
                                    value="{{old('collection_name')}}">
                                    <label for="floatingInput">Tên Bộ sưu tập*</label>
                                    @error('collection_name')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('released') is-invalid @enderror" id="floatingInput" name="released" placeholder="Năm ra mắt"
                                    value="{{old('released')}}">
                                    <label for="floatingInput">Năm ra mắt*</label>
                                    @error('released')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="collection_desc">Mô tả Bộ sưu tập*</label>
                                    <textarea rows="10" class="form-control @error('collection_desc') is-invalid @enderror" id="floatingInput" name="collection_desc" placeholder="Mô tả">
                                        {{old('collection_desc')}}
                                    </textarea>
                                    @error('collection_desc')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_img">Ảnh Banner*</label>
                                    <input type="file" class="form-control @error('banner_img') is-invalid @enderror" id="banner_img" name="banner_img">
                                    @error('banner_img')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <img src="#" alt="Image Preview" id="banner_img_preview" class="d-none img-fluid rounded mb-2" width="100" height="150">
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
