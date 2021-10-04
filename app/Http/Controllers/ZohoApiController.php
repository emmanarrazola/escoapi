<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ZohoApiModel;
use App\Models\ZohoAuthModel;
use App\Models\ApiMethodModel;

class ZohoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zohoapis = ZohoApiModel::from('zoho_api as a')
                        ->join('api_methods as b', 'a.api_method_id','b.id')
                        ->where('a.isdelete', 0)->where('a.id', '<>', 1000)
                        ->select('a.*', 'b.description as method')
                        ->get();

        return view('zohoapi.zohoapi-master', ['zohoapis'=>$zohoapis]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $methods = ApiMethodModel::where('id', '<>', 1000)->where(['isactive'=>1,'isdelete'=>0])->get();
        $auths = ZohoAuthModel::where('id', '<>', 1000)->where(['isactive'=>1,'isdelete'=>0])->get();
        return view('zohoapi.zohoapi-new', ['methods'=>$methods, 'auths'=>$auths]);
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
            'url'=>$request->url,
            'api_method_id'=>$request->method,
            'zoho_auth_id'=>$request->zohoauth,
            'isrequest'=>(isset($request->isrequest)) ? $request->isrequest : 0,
            'isauth'=>(isset($request->isauth)) ? $request->isauth : 0,
            'iscode'=>(isset($request->iscode)) ? $request->iscode : 0,
            'isrefresh'=>(isset($request->isrefresh)) ? $request->isrefresh : 0,
            'isactive'=>(isset($request->isactive)) ? $request->isactive : 0,
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
        $auths = ZohoAuthModel::where('id', '<>', 1000)->where('isdelete',0)->get();
        $methods = ApiMethodModel::where('id', '<>', 1000)->where(['isactive'=>1,'isdelete'=>0])->get();

        return view('zohoapi.zohoapi-edit', ['zohoapi'=>$zohoapi, 'methods'=>$methods, 'auths'=>$auths]);
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
            'url'=>$request->url,
            'api_method_id'=>$request->method,
            'zoho_auth_id'=>$request->zohoauth,
            'isrequest'=>(isset($request->isrequest)) ? $request->isrequest : 0,
            'isauth'=>(isset($request->isauth)) ? $request->isauth : 0,
            'iscode'=>(isset($request->iscode)) ? $request->iscode : 0,
            'isrefresh'=>(isset($request->isrefresh)) ? $request->isrefresh : 0,
            'isactive'=>(isset($request->isactive)) ? $request->isactive : 0,
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
