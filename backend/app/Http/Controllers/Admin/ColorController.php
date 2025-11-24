<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddColorRequest;
use App\Http\Requests\UpdateColorRequest;
use App\Models\Color;


class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.colors.index')->with([
            'colors' => Color::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddColorRequest $req)
    {
        if($req->validated()){
            Color::create($req->validated());
            return redirect()->route('admin.colors.index')->with([
                'success' => "Màu đã được thêm thành công!"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.colors.edit')->with([
            'color' => $color
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $req, Color $color)
    {
        if($req->validated()){
            $color->update($req->validated());
        }
        return redirect()->route('admin.colors.index')->with([
            'success' => "Màu được chọn đã được cập nhật thành công!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')->with([
            'success' => "Màu được chọn đã xóa thành công"
        ]);
    }
}
