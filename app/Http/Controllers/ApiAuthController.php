<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SystemSetupModel;

use App\Classes\Main;

use Carbon\Carbon;

class ApiAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->code !== null){
            $code = $request->code;
            $response = Main::getapicode($code);            

            if(!isset($response->error)){
                SystemSetupModel::first()->update([
                    'access_token'=>$response->access_token,
                    'refresh_token'=>$response->refresh_token,
                    'expires_in'=>Carbon::now()->addSeconds($response->expires_in)
                ]);
            }else{
                SystemSetupModel::first()->update(['code'=>$code]);
            }
            
            return redirect()->route('desk_departments.create');
        }else{
            abort(404);
        }
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
