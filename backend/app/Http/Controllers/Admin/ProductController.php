<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index')->with([
            'products' => Product::with('collection')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collections = Collection::all();
        return view('admin.products.create')->with([
            'collections' => $collections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProductRequest $req)
    {
        if($req->validated()){
            $data = $req->validated();

            $data['thumbnail'] = $this->saveImage($req->file('thumbnail'));
            if($req->has('first_img')){
                $data['first_img'] = $this->saveImage($req->file('first_img'));
            }
            if($req->has('second_img')){
                $data['second_img'] = $this->saveImage($req->file('second_img'));
            }
            if($req->has('third_img')){
                $data['third_img'] = $this->saveImage($req->file('third_img'));
            }
            if($req->has('fourth_img')){
                $data['fourth_img'] = $this->saveImage($req->file('fourth_img'));
            }

            $data['slug'] = Str::slug($req->product_name);
            $product = Product::create($data);

            return redirect()->route('admin.products.index')->with([
                'success' => 'Sản phẩm mới đã được thêm thành công'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $collections = Collection::all();
        return view('admin.products.edit')->with([
            'collections' => $collections,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $req, Product $product)
    {
        if($req->validated()){
            $data = $req->validated();
            if($req->has('thumbnail')){
                $this->removeProductImageFromStorage($product->thumbnail);
                $data['thumbnail'] = $this->saveImage($req->file('thumbnail'));
            }
            if($req->has('first_img')){
                $this->removeProductImageFromStorage($product->first_img);
                $data['first_img'] = $this->saveImage($req->file('first_img'));
            }
            if($req->has('second_img')){
                $this->removeProductImageFromStorage($product->second_img);
                $data['second_img'] = $this->saveImage($req->file('second_img'));
            }
            if($req->has('third_img')){
                $this->removeProductImageFromStorage($product->third_img);
                $data['third_img'] = $this->saveImage($req->file('third_img'));
            }
            if($req->has('fourth_img')){
                $this->removeProductImageFromStorage($product->fourth_img);
                $data['fourth_img'] = $this->saveImage($req->file('fourth_img'));
            }

            $data['slug'] = Str::slug($req->product_name);
            $data['status'] = $req->status;
            $product->update($data);
            return redirect()->route('admin.products.index')->with([
                'success' => "Sản phẩm đã được cập nhật thành công!"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->removeProductImageFromStorage($product->thumbnail);
        $this->removeProductImageFromStorage($product->first_img);
        $this->removeProductImageFromStorage($product->second_img);
        $this->removeProductImageFromStorage($product->third_img);
        $this->removeProductImageFromStorage($product->fourth_img);

        $product->delete();
        return redirect()->route('admin.products.index')->with([
            'success' => 'Đã xóa sản phẩm thành công!'
        ]);
    }

    public function saveImage($file){
        $image_name = time().'_'.$file->getClientOriginalName();
        $file->storeAs('images/products',$image_name,'public');
        return 'storage/images/products/'.$image_name;
    }

    public function removeProductImageFromStorage($file){
        if(empty($file)){
            return;
        }

        $path = public_path($file);
        if(File::exists($path)){
            File::delete($path);
        }
    }
}
