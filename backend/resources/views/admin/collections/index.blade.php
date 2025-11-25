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
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="mt-2">Bộ sưu tập ({{$collections->count()}})</h3>
                    <a href="{{route('admin.collections.create')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <hr>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên bộ sưu tập</th>
                                <th scope="col">Năm phát hành</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collections as $key => $collection)
                                <tr>
                                    <th scope="row">{{$key += 1}}</th>
                                    <td>{{$collection->collection_name}}</td>
                                    <td>
                                        {{$collection->released}}
                                    </td>
                                    <td>
                                        <img src="{{asset($collection->banner_img)}}" alt="{{$collection->banner_img}}" class="img-fluid rounded" width="60" height="60">
                                    </td>

                                    <td>
                                        <a href="{{route('admin.collections.edit', $collection->slug)}}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="deleteItem({{$collection->collection_id}})" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="{{$collection->collection_id}}" action="{{route('admin.collections.destroy', $collection->slug)}}" method="post">
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
