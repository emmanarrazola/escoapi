<?php

namespace App\Http\Controllers;

use App\Models\ZohoDeskTicketModel;

use Illuminate\Http\Request;

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
}
