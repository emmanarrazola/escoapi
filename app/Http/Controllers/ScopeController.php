<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ScopeModel;

class ScopeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scopes = ScopeModel::where('isdelete', 0)->where('id','<>', 1000)->get();

        return view('scopes.scopes-master', ['scopes'=>$scopes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('scopes.scopes-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $scope = ScopeModel::create([
            'description'=>$request->description,
            'zoho_scope'=>$request->zoho_scope,
            'isactive'=>$request->isactive
        ]);

        return redirect()->route('scopes.index')->with('success', 'Record has been created!');
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
        $scope = ScopeModel::where('id', $id)->firstOrFail();

        return view('scopes.scopes-edit', ['scope'=>$scope]);
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
        $scope = ScopeModel::where('id', $id)->update([
            'description'=>$request->description,
            'zoho_scope'=>$request->zoho_scope,
            'isactive'=>$request->isactive
        ]);

        return redirect()->route('scopes.index')->with('success', 'Record has been updated!');
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
