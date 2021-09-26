<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ZohoApiModel;

class ZohoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zohoapis = ZohoApiModel::where('isdelete', 0)->where('id', '<>', 1000)->get();

        return view('zohoapi.zohoapi-master', ['zohoapis'=>$zohoapis]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('zohoapi.zohoapi-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $zohoapi = ZohoApiModel::create([
            'description'=>$request->description,
            'url'=>$request->url
        ]);

        return redirect()->route('zohoapi.index')->with('success', 'Record has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $zohoapi = ZohoApiModel::where('id', $id)->firstOrFail();

        return view('zohoapi.zohoapi-edit', ['zohoapi'=>$zohoapi]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $zohoapi = ZohoApiModel::where('id', $id)->update([
            'description'=>$request->description,
            'url'=>$request->url
        ]);

        return redirect()->route('zohoapi.index')->with('success', 'Record has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
