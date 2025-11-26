<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Collection;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()   {
        return ProductResource::collection(
            Product::with(['collection'])->latest()->get()
        )->additional([
            'collections' => Collection::has('products')->get()
        ]);
    }

    public function show(Product $product){
        return ProductResource::make(
            $product->load(['collection'])
        );
    }

    public function filterProductsByCollection(Collection $collection){
        return ProductResource::collection(
            $collection->products()->with(['collection'])->latest()->get()
        )->additional([
            'collections' => Collection::has('products')->get()
        ]);
    }

    public function findProductsByTerm($searchTerm){
        return ProductResource::collection(
            Product::where('product_name', 'LIKE', '%'.$searchTerm.'%')->with(['collection'])->latest()->get()
        )->additional([
            'collections' => Collection::has('products')->get()
        ]);
    }

    public function filterByShape($shape){
        $product = Product::where('shape', $shape)->with(['collection'])->latest()->get();
        return ProductResource::collection($product)->additional([
            'collections' => Collection::has('products')->get()
        ]);
    }

    public function filterByMaterial($material){
        $product = Product::where('material', $material)->with(['collection'])->latest()->get();
        return ProductResource::collection($product)->additional([
            'collections' => Collection::has('products')->get()
        ]);
    }
}
