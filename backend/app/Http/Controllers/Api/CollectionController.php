<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(){
        return CollectionResource::collection(
            Collection::with(['products'])->latest()->get()
        );
    }

    public function show(Collection $collection){
        if(!$collection){
            abort(404);
        } else{
            return CollectionResource::make(
                $collection->load(['products'])
            );
        }
    }
}
