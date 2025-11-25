<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.collections.index')->with([
            'collections' => Collection::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.collections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCollectionRequest $req)
    {
        if($req->validated()){
            $data = $req->validated();
            $data['banner_img'] = $this->saveBannerImage($req->file('banner_img'));
            $data['slug'] = Str::slug($req->collection_name);

            Collection::create($data);
            return redirect()->route('admin.collections.index')->with([
                'success' => 'Bộ sưu tập mới đã được thêm thành công'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        return view('admin.collections.edit')->with([
            'collection' => $collection
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCollectionRequest $req, Collection $collection)
    {
        if($req->validated()){
            $data = $req->validated();

            if($req->has('banner_img')){
                $this->removeBannerImageFromStorage($collection->banner_img);
                $data['banner_img'] = $this->saveBannerImage($req->file('banner_img'));
            }

            $data['slug'] = Str::slug($req->collection_name);
            $collection->update($data);
            return redirect()->route('admin.collections.index')->with([
                'success' => 'Thông tin bộ sưu tập đã cập nhật thành công'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        $this->removeBannerImageFromStorage($collection->banner_img);
        $collection->delete();
        return redirect()->route('admin.collections.index')->with([
            'success' => 'Đã xóa thành công bộ sưu tập'
        ]);
    }

    public function saveBannerImage($file){
        $image_name = time().'_'.$file->getClientOriginalName();
        $file->storeAs('images/collections', $image_name, 'public');
        return 'storage/images/collections/'.$image_name;
    }

    public function removeBannerImageFromStorage($file){
        if(empty($file)){
            return;
        }
        $path = public_path($file);
        if(File::exists($path)){
            File::delete($path);
        }
    }
}
