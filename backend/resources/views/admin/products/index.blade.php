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
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="mt-2">Sản phẩm ({{$products->count()}})</h3>
                    <a href="{{route('admin.products.create')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Loại</th>
                                <th scope="col">Chất liệu</th>
                                <th scope="col">BST</th>
                                <th scope="col">SL</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Màu sắc</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <th scope="row">{{$key += 1}}</th>
                                    <td>{{$product->product_name}}</td>
                                    <td>
                                        {{$product->shape}}
                                    </td>
                                    <td>
                                        {{ $product->material }}
                                    </td>
                                    <td>
                                        {{ $product->collection ? $product->collection->collection_name : 'N/A' }}
                                    </td>
                                    <td>{{$product->product_qty}}</td>
                                    <td>{{$product->product_price}}</td>
                                    {{-- <td>
                                        <img src="{{asset($product->thumbnail)}}" alt="{{$product->thumbnail}}" class="img-fluid" width="60" height="60">
                                    </td> --}}
                                    <td>
                                        @foreach ($product->colors as $color)
                                            <span class="badge bg-light text-dark">
                                                {{ $color->color_name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($product->status)
                                            <span class="badge bg-success p-2">
                                                Đang bán
                                            </span>
                                        @else
                                            <span class="badge bg-danger p-2">
                                                Tạm ngưng
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{route('admin.products.edit', $product->slug)}}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="deleteItem({{$product->product_id}})" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="{{$product->product_id}}" action="{{route('admin.products.destroy', $product->slug)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
