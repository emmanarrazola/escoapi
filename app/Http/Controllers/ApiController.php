<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ZohoDeskTicketModel;
use App\Models\DealsModel;
use App\Models\DeskPayloadModel;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /* */

    public function get_zoho_tickets(){
        $tickets = ZohoDeskTicketModel::from('zoho_tickets as a');
        $tickets->leftJoin('zoho_desk_status as b', 'a.status', 'b.description');
        $tickets->leftJoin('zoho_desk_account as c', 'a.accountId', 'c.id');
        $tickets->leftJoin('zoho_desk_agent as d', 'a.agent_id', 'd.id');
        $tickets->select(
            'a.id as ID', 
            'a.ticketNumber as Ticket Number',
            'a.subject as Subject', 
            'd.name as Ticket Owner',
            'a.status as Status', 
            'a.createdTime as Created Time', 
            'a.category as Category', 
            'a.subcategory as Sub Category', 
            'a.dueDate as Due Date', 
            'a.cf_floor as Floor', 
            'a.cf_service_coverage as Service Coverage', 
            'a.cf_required_date as Required Date', 
            'a.cf_requester as Requester', 
            'a.cf_room_name as Room Name', 
            'c.accountName as Company Name',
            'a.closedTime as Closed Date',
            'a.cf_purpose as Purpose'
        );
        $tickets = $tickets->get();

        return response()->json($tickets);
    }
    public function get_crm_deals(){
        $deals = DealsModel::where('isdelete', 0)->select(
            'id as ID',
            'owner_name as Owner',
            'currency_symbol as Currency Symbol',
            'Last_Activity_Time as Last Activity Time',
            'Industry as Industry',
            'state as State',
            'process_flow as Process Flow',
            'Deal_Name as Deal Name',
            'Exchange_Rate as Exchange Rate',
            'Currency as Currency',
            'Stage as Stage',
            'Solutions_Services as Solution Services',
            'approved as Approved',
            'approval_delegate as Is Delegate',
            'approval_approve as Is Approve',
            'approval_reject as Is Reject',
            'approval_resubmit as Is Resubmit',
            'Territory as Territory',
            'Maintenance1 as Maintenance',
            'Created_Time as Created Time',
            'Change_Log_Time as Change Log Time',
            'Duration_of_License_if_have as Duration of License',
            'editable as Is Editable',
            'Site_Location as Site Location',
            'ELMO1 as ELMO',
            'company_name as Company Name',
            'created_name as Create By',
            'Website_Form_Name as Website Form Name',
            'Gross_Profit_Amount as Gross Profit Amount',
            'category as Category',
            'Description as Description',
            'Campaign_Source as Campaign Source',
            'review_process_approve as Review Process Is Approve',
            'review_process_reject as Review Process Is Reject',
            'review_process_resubmit as Review Process Is Resubmit',
            'Closing_Date as Closing Date',
            'Record_Image as Record Image',
            'modified_by_name as Modified By',
            'review as Review',
            'Insightly_Reference_Number as Insightly Reference Number',
            'Lead_Conversion_Time as Lead Conversion Time',
            'Expected_Revenue as Expected Revenue',
            'Overall_Sales_Duration as Overall Sales Duration',
            'account_name as Account Name',
            'Expected_Completion_Date as Expected Completion Date',
            'Modified_Time as Modified Time',
            'Amount as Amount',
            'Probability as Probability',
            'Next_Step as Next Step',
            'GP as GP',
            'orchestration as Orchestration',
            'contact_name as Contact Name',
            'Sales_Cycle_Duration as Sales Cycle Duration',
            'Services as Services',
            'in_merge as In Merge',
            'Lead_Source as Lead Source',
            'Tag as Tag',
            'approval_state as Approval State'
        )->get();

        return response()->json($deals);
    }



    /* TRIGGERS */
    public function desk_payload(Request $request){
        if($request->all() !== NULL){
            $count = count($request->all());
            $payload = json_encode($request->all());
            if($count > 0){
                if(DeskPayloadModel::create(['payload'=>$payload])){
                    return response()->json(['msg'=>'ok']);
                }else{
                    return response()->json(['msg'=>'error']);   
                }
            }else{
                return response()->json(['msg'=>'no payload data']);
            }
        }
    }
    public function zoho_form_webhooks(){
        $payload = DeskPayloadModel::where('isconverted',0)->first();

        return response()->json(json_decode($payload->payload));
    }
}
