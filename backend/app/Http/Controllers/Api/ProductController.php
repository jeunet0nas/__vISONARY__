<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;

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

    public function findProductsByTerm($searchTerm){
        return ProductResource::collection(
            Product::where('product_name', 'LIKE', '%'.$searchTerm.'%')->with(['collection'])->latest()->get()
        )->additional([
            'collections' => Collection::has('products')->get()
        ]);
    }

    public function filterProductsByCollection(Collection $collection){
        return ProductResource::collection(
            $collection->products()->with(['collection'])->latest()->get()
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

    public function filterProductsMulti(Request $request) {
        $query = Product::query()->with(['collection']);

        if ($request->has('collections') && is_array($request->collections) && count($request->collections)) {
            $collectionSlugs = $request->collections;
            $collectionIds = Collection::whereIn('slug', $collectionSlugs)->pluck('collection_id');
            if (count($collectionIds)) {
                $query->whereIn('collection_id', $collectionIds);
            }
        }
        if ($request->has('shapes') && is_array($request->shapes) && count($request->shapes)) {
            $query->whereIn('shape', $request->shapes);
        }
        if ($request->has('materials') && is_array($request->materials) && count($request->materials)) {
            $query->whereIn('material', $request->materials);
        }

        $products = $query->latest()->get();
        return ProductResource::collection($products)->additional([
            'collections' => Collection::has('products')->get()
        ]);
    }
}
