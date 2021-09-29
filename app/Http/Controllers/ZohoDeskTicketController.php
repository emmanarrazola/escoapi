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
        $validate_token = true; //Main::validate_token();
        if($validate_token !== false){
            $systemsetup = SystemSetupModel::first();
            
            $addtlparam['from'] = 1;
            
            $response = Main::getapidata(1005, $addtlparam);
            while($response !== null){
                if(!isset($response->error) && !isset($response->errorCode)){
                    foreach($response->data as $ticket){
                        $created_at = Carbon::parse($ticket->createdTime)->format('Y-m-d H:i:s');
                        $due_date = Carbon::parse($ticket->dueDate)->format('Y-m-d H:i:s');
                        $required_date = Carbon::parse($ticket->cf->cf_required_date)->format('Y-m-d H:i:s');

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
                            'agent_id'=>$ticket->assignee->id,
                        ];
    
                        ZohoDeskTicketModel::updateOrCreate(['id'=>$ticket->id], $data);
                    }
                    $addtlparam['from'] += $systemsetup->ticket_limit;
                    $response = Main::getapidata(1005, $addtlparam);
                }else{
                    return redirect()->route('desk_tickets.index')->with('warning', $response->message);
                }
            };
            return redirect()->route('desk_tickets.index')->with('success', 'Desk Tickets Sync was Successful!');
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
