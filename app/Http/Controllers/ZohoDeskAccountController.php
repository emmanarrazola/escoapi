<?php

namespace App\Http\Controllers;

use App\Models\ZohoDeskAccountModel;
use App\Models\SystemSetupModel;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Classes\Main;

class ZohoDeskAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = ZohoDeskAccountModel::all();

        return view('zohodesk-account.zohodesk-account-master', ['accounts'=>$accounts]);
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
            $systemsetup = SystemSetupModel::first();

            $addtlparam['from'] = 1;
            $response = Main::getapidata(1007, $addtlparam);
            
            while($response !== null){
                if(!isset($response->error) && !isset($response->errorCode)){
                    foreach($response->data as $account){
                        $created_at = Carbon::parse($account->createdTime)->format('Y-m-d H:i:s');
                        $data = [
                            'accountName'=>$account->accountName,
                            'email'=>$account->email,
                            'website'=>$account->website,
                            'phone'=>$account->phone,
                            'createdTime'=>$created_at,
                            'webUrl'=>$account->webUrl,
                            'badPercentage'=>$account->customerHappiness->badPercentage,
                            'okPercentage'=>$account->customerHappiness->okPercentage,
                            'goodPercentage'=>$account->customerHappiness->goodPercentage,
                            'zohoCRMAccount'=>(isset($account->zohoCRMAccount->id)) ? $account->zohoCRMAccount->id : 1000,
                        ];

                        ZohoDeskAccountModel::updateOrCreate(['id'=>$account->id], $data);
                    }
                    
                }else{
                    return redirect()->route('desk_accounts.index')->with('warning', $response->message);
                }
                $addtlparam['from'] += $systemsetup->general_limit;
                $response = Main::getapidata(1007, $addtlparam);
            }
            return redirect()->route('desk_accounts.index')->with('success', 'Desk Accounts Sync was Successful!');
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
