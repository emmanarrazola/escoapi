<?php

namespace App\Http\Controllers;

use App\Models\ZohoDeskDeptModel;
use App\Models\ZohoApiModel;
use App\Models\ParametersModel;
use App\Models\ScopeModel;
use App\Models\SystemSetupModel;

use App\Classes\Main;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ZohoDeskDeptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depts = ZohoDeskDeptModel::where('id','<>', 1000)->get();

        return view('zohodesk-dept.zohodesk-dept-master', ['depts'=>$depts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validate_token = Main::validate_token(1001);
        if($validate_token !== false){
            $systemsetup = SystemSetupModel::first();

            $addtlparam['from'] = 1;

            $response = Main::getapidata(1002, $addtlparam);
            
            while($response !== null){
                if(!isset($response->error) && !isset($response->errorCode)){
                    foreach($response->data as $dept){
                        $created_at = Carbon::parse($dept->createdTime)->format('Y-m-d H:i:s');
                        $data = [
                            'name'=>$dept->name,
                            'description'=>$dept->description,
                            'createdTime'=>$created_at,
                            'creatorId'=>$dept->creatorId,
                            'hasLogo'=>($dept->hasLogo === true) ? 1 : 0,
                            'chatStatus'=>$dept->chatStatus,
                            'nameInCustomerPortal'=>$dept->nameInCustomerPortal,
                            'isAssignToTeamEnabled'=>($dept->isAssignToTeamEnabled === true) ? 1 : 0,
                            'isEnabled'=>($dept->isEnabled === true) ? 1 : 0,
                            'isVisibleInCustomerPortal'=>($dept->isVisibleInCustomerPortal === true) ? 1 : 0,
                            'sanitizedName'=>$dept->sanitizedName,
                            'isDefault'=>($dept->isDefault === true) ? 1 : 0
                        ];

                        ZohoDeskDeptModel::updateOrCreate(['id'=>$dept->id], $data);
                    }
                }else{
                    return redirect()->route('desk_departments.index')->with('warning', $response->message);
                }

                $addtlparam['from'] += $systemsetup->general_limit;
                $response = Main::getapidata(1002, $addtlparam);
            }
            return redirect()->route('desk_departments.index')->with('success', 'Desk Department Sync was Successful!');
        }else{
            $query = Main::apiauthenticate(1001);

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
        $apicon = new \GuzzleHttp\Client([
            'http_errors' => false,
        ]);

        dd($apicon);
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
