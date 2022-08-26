<?php

namespace App\Http\Controllers;

use App\Models\Mcc;
use Illuminate\Http\Request;

class MccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'MCC';
        $data['category'] = Mcc::latest()->get();
        return view('admin.category.mcc', $data);
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
        $data = new Mcc();
        $data->name = $request->name;
        $data->type = $request->type;
        $data->status = 1;
        $data->save();
        return back()->with('toast_success', 'Category added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mcc  $Mcc
     * @return \Illuminate\Http\Response
     */
    public function show(Mcc $Mcc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mcc  $Mcc
     * @return \Illuminate\Http\Response
     */
    public function edit(Mcc $Mcc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mcc  $Mcc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $data = Mcc::findOrFail($request->id);
        $data->name = $request->name;
        $data->type = $request->type;
        $data->save();
        return back()->with('toast_success', 'MCC was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mcc  $Mcc
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $data = Mcc::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'MCC deleted!');
    }

    public function disable($id)
    {
        $data = Mcc::find($id);
        $data->status = 0;
        $data->save();
        return back()->with('toast_success', 'MCC disabled.');
    }
    public function enable($id)
    {
        $data = Mcc::find($id);
        $data->status = 1;
        $data->save();
        return back()->with('toast_success', 'MCC is now active.');
    }
}
