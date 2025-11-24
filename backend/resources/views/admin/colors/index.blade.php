@extends('admin.layouts.app')

@section('title')
    Màu sắc
@endsection

@section('content')
<div class="row">
    @include('admin.layouts.sidebar')
    <div class="col-md-9">
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="mt-2">Màu ({{$colors->count()}})</h3>
                    <a href="{{route('admin.colors.create')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên màu</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $key => $color)
                                <tr>
                                    <th scope="row">{{$key += 1}}</th>
                                    <td>{{$color->color_name}}</td>
                                    <td>
                                        <a href="{{route('admin.colors.edit', $color->color_id)}}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="deleteItem({{$color->color_id}})" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="{{$color->color_id}}" action="{{route('admin.colors.destroy', $color->color_id)}}" method="post">
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
