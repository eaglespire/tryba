<?php

namespace App\Http\Controllers;

use App\Models\Fundcategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Image;

class FundcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Product Category';
        $data['category'] = Fundcategory::latest()->get();
        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = new Fundcategory();
        $data->name = $request->name;
        $data->description = $request->description;
        $data->slug = str_slug($request->name);
        $data->save();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'category_' . time() . '.' . $image->extension();
            $location = public_path('asset/images/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
            $data->save();
        }
        return back()->with('success', 'Category added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fundcategory  $fundcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Fundcategory $fundcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fundcategory  $fundcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Fundcategory $fundcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fundcategory  $fundcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fundcategory $fundcategory)
    {
        //
        $data = Fundcategory::findOrFail($request->id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->slug = str_slug($request->name);
        $data->save();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'category_' . time() . '.' . $image->extension();
            $location = public_path('asset/images/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
            $data->save();
        }
        return back()->with('success', 'Category was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fundcategory  $fundcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fundcategory $fundcategory, $id)
    {
        $data = Fundcategory::findOrFail($id);
        $check = Product::wherecat_id($data->id)->count();
        if ($check > 0) {
            return back()->with('alert', 'You can not delete this category as you have products with this category');
        } else {
            $data->delete();
            return back()->with('success', 'Category deleted!');
        }
    }

    public function disable($id)
    {
        $data = Fundcategory::find($id);
        $data->status = 0;
        $data->save();
        return back()->with('success', 'category disabled.');
    }
    public function enable($id)
    {
        $data = Fundcategory::find($id);
        $data->status = 1;
        $data->save();
        return back()->with('success', 'category is now active.');
    }
}
