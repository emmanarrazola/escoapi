<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\WarehouseModel;
use App\Models\SystemSetupModel;

use App\Classes\Main;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = WarehouseModel::all();

        return view('inventory-warehouse.inv-warehouse-master', ['warehouses'=>$warehouses]);
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

            $addtlparam['page'] = 100;

            $response = Main::getapidata(1010, $addtlparam);

             
            if(!isset($response->error) && !isset($response->errorCode)){
                foreach($response->warehouses as $warehouse){

                    $data = [
                        'warehouse_name'=>$warehouse->warehouse_name,
                        'attention'=>$warehouse->attention,
                        'address'=>$warehouse->address,
                        'address1'=>$warehouse->address1,
                        'address2'=>$warehouse->address2,
                        'city'=>$warehouse->city,
                        'state'=>$warehouse->state,
                        'state_code'=>($warehouse->state_code !== "") ? $warehouse->state_code : null,
                        'country'=>$warehouse->country,
                        'zip'=>$warehouse->zip,
                        'phone'=>$warehouse->phone,
                        'email'=>$warehouse->email,
                        'is_primary'=>($warehouse->is_primary === true) ? 1 : 0,
                        'status'=>($warehouse->status === 'active') ? 1 : 0,
                        'is_fba_warehouse'=>($warehouse->is_fba_warehouse === true) ? 1 : 0,
                        'sales_channels'=>json_encode($warehouse->sales_channels)  
                    ];
                    
                    try { 
                        WarehouseModel::updateOrCreate(['id'=>$warehouse->warehouse_id], $data);
                    } catch(\Illuminate\Database\QueryException $ex){ 
                        dd($ex->getMessage()); 
                    }
                    
                }
                return redirect()->route('warehouses.index')->with('success', 'Inventory Warehouses Sync was Successful!');
            }else{
                return redirect()->route('warehouses.index')->with('warning', $response->message);
            }

            
            return redirect()->route('warehouses.index')->with('success', 'Inventory Items Sync was Successful!');
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
