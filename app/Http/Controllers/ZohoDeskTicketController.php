<?php

namespace App\Http\Controllers;

use App\Models\ZohoDeskTicketModel;
use App\Models\SystemSetupModel;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Classes\Main;

class ZohoDeskTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = ZohoDeskTicketModel::from('zoho_tickets as a');
        $tickets->leftJoin('zoho_desk_status as b', 'a.status', 'b.description');
        $tickets->leftJoin('zoho_desk_account as c', 'a.accountId', 'c.id');
        $tickets->select('a.*', 'b.description', 'b.color_class', 'c.accountName', 'a.accountId');
        $tickets->where('a.isdelete', 0);
        $tickets = $tickets->get();

        return view('zohodesk-ticket.zohodesk-ticket-master', ['tickets'=>$tickets]);
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
            
            $addtlparam['from'] = 1;
            
            $response = Main::getapidata(1005, $addtlparam);
            $ids = [];
            
            while($response !== null){
                if(!isset($response->error) && !isset($response->errorCode)){
                    foreach($response->data as $ticket){
                        $created_at = Carbon::parse($ticket->createdTime)->format('Y-m-d H:i:s');
                        $due_date = Carbon::parse($ticket->dueDate)->format('Y-m-d H:i:s');
                        $required_date = Carbon::parse($ticket->cf->cf_required_date)->format('Y-m-d H:i:s');
                        $closed_date = Carbon::parse($ticket->closedTime)->format('Y-m-d H:i:s');

                        $data = [
                            'ticketNumber'=>$ticket->ticketNumber,
                            'subject'=>$ticket->subject,
                            'status'=>$ticket->status,
                            'createdTime'=>$created_at,
                            'category'=>$ticket->category,
                            'subCategory'=>$ticket->subCategory,
                            'dueDate'=>$due_date,
                            'accountId'=>$due_date,
                            'dueDate'=>$due_date,
                            'accountId'=>$ticket->accountId,
                            'cf_floor'=>$ticket->cf->cf_floor,
                            'cf_service_coverage'=>$ticket->cf->cf_service_coverage,
                            'cf_required_date'=>$required_date,
                            'cf_requester'=>$ticket->cf->cf_requester,
                            'cf_room_name'=>$ticket->cf->cf_room_name,
                            'cf_purpose'=>$ticket->cf->cf_purpose,
                            'agent_id'=>isset($ticket->assignee->id) ? $ticket->assignee->id : 1000,
                            'closedTime'=>$closed_date,
                            'departmentId'=>$ticket->departmentId,
                            'cf_root_cause'=>(isset($ticket->cf->cf_root_cause)) ? $ticket->cf->cf_root_cause : null
                        ];
    
                        ZohoDeskTicketModel::updateOrCreate(['id'=>$ticket->id], $data);
                        $ids[] = $ticket->id;
                    }
                    $addtlparam['from'] += $systemsetup->ticket_limit;
                    $response = Main::getapidata(1005, $addtlparam);
                }else{
                    return redirect()->route('desk_tickets.index')->with('warning', $response->message);
                }
            };
            ZohoDeskTicketModel::whereNotIn('id', $ids)->update(['isdelete'=>1]);
            return redirect()->route('desk_tickets.index')->with('success', 'Desk Tickets Sync was Successful!');
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
