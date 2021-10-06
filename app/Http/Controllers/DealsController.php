<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

use App\Models\SystemSetupModel;
use App\Models\DealsModel;

use App\Classes\Main;

class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deals = DealsModel::all();

        return view('deals.deals-master', ['deals'=>$deals]);
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

            $addtlparam['page'] = 1;

            $response = Main::getapidata(1011, $addtlparam);
            while($response !== null && count($response->data) !== 0){
                
                if(!isset($response->error) && !isset($response->errorCode)){
                    foreach($response->data as $deals){
                        
                        $created_at = Carbon::parse($deals->Created_Time)->format('Y-m-d H:i:s');
                        $modified_at = Carbon::parse($deals->Modified_Time)->format('Y-m-d H:i:s');
                        $closing_date = Carbon::parse($deals->Closing_Date)->format('Y-m-d H:i:s');
                        $completion_date = Carbon::parse($deals->Expected_Completion_Date)->format('Y-m-d H:i:s');
                        $last_activity_time = Carbon::parse($deals->Last_Activity_Time)->format('Y-m-d H:i:s');
                        $change_log_time = Carbon::parse($deals->Change_Log_Time__s)->format('Y-m-d H:i:s');
                        $s = Carbon::parse($deals->s)->format('Y-m-d H:i:s');

                        
                        $lead_conversion_time = (isset($deals->Lead_Conversion_Time)) ? $deals->Lead_Conversion_Time : 0.00;
                        $overall_sales_duration = (isset($deals->Overall_Sales_Duration)) ? $deals->Overall_Sales_Duration : 0.00;
                        $sales_cycle_duration = (isset($deals->Sales_Cycle_Duration)) ? $deals->Sales_Cycle_Duration : 0.00;
                        $company_id = (isset($deals->Company_Name->id)) ? $deals->Company_Name->id : 0.00;
                        $company_name = (isset($deals->Company_Name->name)) ? $deals->Company_Name->name : 0.00;
                        $account_id = (isset($deals->Account_Name->id)) ? $deals->Account_Name->id : 0.00;
                        $account_name = (isset($deals->Account_Name->name)) ? $deals->Account_Name->name : 0.00;
                        $contact_id = (isset($deals->Contact_Name->id)) ? $deals->Contact_Name->id : 0.00;
                        $contact_name = (isset($deals->Contact_Name->name)) ? $deals->Contact_Name->name : 0.00;
                        $expected_revenue = (isset($deals->Expected_Revenue)) ? $deals->Expected_Revenue : 0.00;
                        $amount = (isset($deals->Amount)) ? $deals->Amount : 0.00;
                        
                        $data = [
                            'id'=>$deals->id,
                            'owner_id'=>$deals->Owner->id,
                            'owner_name'=>$deals->Owner->name,
                            'currency_symbol'=>$deals->{'$currency_symbol'},
                            'followers'=>json_encode($deals->{'$followers'}),
                            'Last_Activity_Time'=>$last_activity_time,
                            'Industry'=>$deals->Industry,
                            'state'=>$deals->{'$state'},
                            'process_flow'=>$deals->{'$process_flow'},
                            'Deal_Name'=>$deals->Deal_Name,
                            'Exchange_Rate'=>$deals->Exchange_Rate,
                            'Currency'=>$deals->Currency,
                            'Stage'=>$deals->Stage,
                            'Solutions_Services'=>(isset($deals->Solution_Services)) ? implode("/", array_unique($deals->Solution_Services)) : null,
                            'approved'=>$deals->{'$approved'},
                            'Hostile_Mitigation'=>(isset($deals->Hostile_Mitigation)) ? implode("/", array_unique($deals->Hostile_Mitigation)) : null,
                            'approval_delegate'=>$deals->{'$approval'}->delegate,
                            'approval_approve'=>$deals->{'$approval'}->approve,
                            'approval_reject'=>$deals->{'$approval'}->reject,
                            'approval_resubmit'=>$deals->{'$approval'}->resubmit,
                            'Territory'=>(isset($deals->Territory)) ? implode("/", array_unique($deals->Territory)) : null,
                            'Maintenance1'=>$deals->Maintenance1,
                            'Created_Time'=>$created_at,
                            'followed'=>$deals->{'$followed'},
                            'Change_Log_Time'=>$change_log_time,
                            'Duration_of_License_if_have'=>$deals->Duration_of_License_if_have,
                            'editable'=>$deals->{'$editable'},
                            'Site_Location'=>$deals->Site_Location,
                            'ELMO1'=>$deals->ELMO1,
                            'company_id'=>$company_id,
                            'company_name'=>$company_name,
                            'created_id'=>$deals->Created_By->id,
                            'created_name'=>$deals->Created_By->name,
                            'Website_Form_Name'=>$deals->Website_Form_Name,
                            'Gross_Profit_Amount'=>$deals->Gross_Profit_Amount,
                            'category'=>$deals->Category,
                            'Description'=>$deals->Description,
                            'Campaign_Source'=>$deals->Campaign_Source,
                            'review_process_approve'=>$deals->{'$review_process'}->approve,
                            'review_process_reject'=>$deals->{'$review_process'}->reject,
                            'review_process_resubmit'=>$deals->{'$review_process'}->resubmit,
                            'Closing_Date'=>$closing_date,
                            'Record_Image'=>$deals->Record_Image,
                            'modified_by_id'=>$deals->Modified_By->id,
                            'modified_by_name'=>$deals->Modified_By->name,
                            'review'=>$deals->{'$review'},
                            'Insightly_Reference_Number'=>$deals->Insightly_Reference_Number,
                            'Lead_Conversion_Time'=>$lead_conversion_time,
                            'Expected_Revenue'=>$expected_revenue,
                            'Overall_Sales_Duration'=>$overall_sales_duration,
                            'account_id'=>$account_id,
                            'account_name'=>$account_name,
                            'Expected_Completion_Date'=>$completion_date,
                            'Modified_Time'=>$modified_at,
                            'Amount'=>$amount,
                            'Probability'=>$deals->Probability,
                            'Next_Step'=>$deals->Next_Step,
                            'GP'=>$deals->GP,
                            'orchestration'=>$deals->{'$orchestration'},
                            'contact_id'=>$contact_id,
                            'contact_name'=>$contact_name,
                            'Sales_Cycle_Duration'=>$sales_cycle_duration,
                            'Services'=>(isset($deals->Services)) ? implode("/", array_unique($deals->Services)) : null,
                            's'=>$s,
                            'in_merge'=>$deals->{'$in_merge'},
                            'Lead_Source'=>$deals->Lead_Source,
                            'Tag'=>json_encode($deals->Tag),
                            'approval_state'=>$deals->{'$approval_state'}
                        ];

                        try { 
                           
                            DealsModel::updateOrCreate(['id'=>$deals->id], $data);
                        } catch(\Illuminate\Database\QueryException $ex){ 
                            dd($data);
                            dd($ex->getMessage()); 
                        }
                        
                    }
                }else{
                    return redirect()->route('crm_deals.index')->with('warning', $response->message);
                }

                $addtlparam['page']++;
                $response = Main::getapidata(1011, $addtlparam);
            }
            return redirect()->route('crm_deals.index')->with('success', 'CRM Deals Sync was Successful!');
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
