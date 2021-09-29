<?php

namespace App\Http\Controllers;

use App\Models\ZohoDeskAgentModel;
use App\Models\ZohoDeskAgentDeptModel;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Classes\Main;

class ZohoDeskAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = ZohoDeskAgentModel::where('id','<>',1000)->get();

        return view('zohodesk-agent.zohodesk-agent-master', ['agents'=>$agents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validate_token = Main::validate_token();
        if($validate_token !== false){
            $response = Main::getapidata(1006);
            if(!isset($response->error) && !isset($response->errorCode)){
                $insert = Main::syncagents($response);
            }else{
                return redirect()->route('desk_departments.index')->with('warning', $response->message);
            }

            $response = Main::getapidata(1006, ['status'=>'DISABLED']);
            if(!isset($response->error) && !isset($response->errorCode)){
                $insert = Main::syncagents($response);
            }else{
                return redirect()->route('desk_departments.index')->with('warning', $response->message);
            }

            $response = Main::getapidata(1006, ['status'=>'DELETED']);
            if(!isset($response->error) && !isset($response->errorCode)){
                $insert = Main::syncagents($response);
            }else{
                return redirect()->route('desk_departments.index')->with('warning', $response->message);
            }

            return redirect()->route('desk_departments.index')->with('success', 'Desk Agents Sync was Successful!');
            
        }else{
            $query = Main::apiauthenticate();

            return redirect($query);
        }
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
