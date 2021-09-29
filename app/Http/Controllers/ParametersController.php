<?php

namespace App\Http\Controllers;

use App\Models\ParametersModel;
use App\Models\ParamsTypeModel;
use App\Models\ZohoApiModel;

use Illuminate\Http\Request;

class ParametersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = ParametersModel::from('zoho_api_params as a');
        $params = $params->join('zoho_api as b', 'a.zoho_api_id', 'b.id');
        $params = $params->join('zoho_api_params_type as c', 'a.params_type_id', 'c.id');
        $params = $params->select('a.*', 'b.description as api_name', 'c.description as params_type')->get();

        return view('params.params-master', ['params'=>$params]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apis = ZohoApiModel::where('isactive', 1)->where('isdelete', 0)->where('id','<>',1000)->get();
        $paramstype = ParamsTypeModel::where('isactive', 1)->where('isdelete', 0)->where('id','<>',1000)->get();

        return view('params.params-new', ['apis'=>$apis, 'paramstype'=>$paramstype]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = ParametersModel::create([
            'zoho_api_id'=>$request->apiname,
            'params_type_id'=>$request->paramstype,
            'params_key'=>$request->key,
            'params_value'=>$request->value,
            'isactive'=>(isset($request->isactive)) ? $request->isactive : 0,
        ]);

        return redirect()->route('parameters.index')->with('success', 'Record has been created!');
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
        $apis = ZohoApiModel::where('isactive', 1)->where('isdelete', 0)->where('id','<>',1000)->get();
        $paramstype = ParamsTypeModel::where('isactive', 1)->where('isdelete', 0)->where('id','<>',1000)->get();
        $param = ParametersModel::where('id', $id)->firstOrFail();

        return view('params.params-edit', ['param'=>$param, 'apis'=>$apis, 'paramstype'=>$paramstype]);
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
        $params = ParametersModel::where('id',$id)->update([
            'zoho_api_id'=>$request->apiname,
            'params_type_id'=>$request->paramstype,
            'params_key'=>$request->key,
            'params_value'=>$request->value,
            'isactive'=>(isset($request->isactive)) ? $request->isactive : 0,
        ]);

        return redirect()->route('parameters.index')->with('success', 'Record has been updated!');
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
