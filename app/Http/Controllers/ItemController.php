<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

use App\Models\SystemSetupModel;
use App\Models\ItemModel;

use App\Classes\Main;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = ItemModel::all();

        return view('inventory-item.inv-item-master', ['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ini_set('max_execution_time', '300');
        $validate_token = Main::validate_token(1001);
        
        if($validate_token !== false){
            $systemsetup = SystemSetupModel::first();

            $addtlparam['page'] = 50;

            $response = Main::getapidata(1009, $addtlparam);
            while($response !== null && count($response->items) !== 0){
                
                if(!isset($response->error) && !isset($response->errorCode)){
                    foreach($response->items as $item){
                        $created_at = Carbon::parse($item->created_time)->format('Y-m-d H:i:s');
                        $modified_at = Carbon::parse($item->last_modified_time)->format('Y-m-d H:i:s');
                        $data = [
                            'name'=>$item->name,
                            'category_id'=>($item->category_id !== "") ? $item->category_id : null,
                            'category_name'=>($item->category_name !== "") ? $item->category_name : null,
                            'unit'=>$item->unit,
                            'status'=>$item->status,
                            'rate'=>$item->rate,
                            'purchase_account_id'=>($item->purchase_account_id !== "") ? $item->purchase_account_id : null,
                            'purchase_account_name'=>($item->purchase_account_name !== "") ? $item->purchase_account_name : null,
                            'account_name'=>$item->account_name,
                            'purchase_rate'=>$item->purchase_rate,
                            'item_type'=>$item->item_type,
                            'product_type'=>$item->product_type,
                            'stock_on_hand'=>(isset($item->stock_on_hand)) ? $item->stock_on_hand : 0.00,
                            'available_stock'=>(isset($item->available_stock)) ? $item->available_stock : 0.00,
                            'actual_available_stock'=>(isset($item->actual_available_stock)) ? $item->actual_available_stock : 0.00,
                            'sku'=>$item->sku,
                            'part_number'=>($item->part_number !== "") ? $item->part_number : null,
                            'reorder_level'=>(isset($item->reorder_level) && $item->reorder_level !== "") ? $item->reorder_level : 0.00,
                            'created_time'=>$created_at,
                            'last_modified_time'=>$modified_at,
                            'cf_type'=>(isset($item->cf_type)) ? $item->cf_type : null,
                            'cf_brand'=>(isset($item->cf_brand)) ? $item->cf_brand : null,
                            'cf_vendor'=>(isset($item->cf_vendor)) ? $item->cf_vendor : null,
                        ];
                        
                        try { 
                            ItemModel::updateOrCreate(['id'=>$item->item_id], $data);
                        } catch(\Illuminate\Database\QueryException $ex){ 
                            dd($ex->getMessage()); 
                        }
                        
                    }
                }else{
                    return redirect()->route('items.index')->with('warning', $response->message);
                }

                $addtlparam['page']++;
                $response = Main::getapidata(1009, $addtlparam);
            }
            return redirect()->route('items.index')->with('success', 'Inventory Items Sync was Successful!');
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
