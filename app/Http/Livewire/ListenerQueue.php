<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PayloadModel;
use App\Models\ZohoDeskTicketModel;
use App\Classes\Main;
use Carbon\Carbon;

class ListenerQueue extends Component
{
    public $loop = 0;
    public $timeout = 500;
    public $reload = 0;
    public $message = "Connecting to Database ";

    protected $listeners = [
        'payload_listener'=>'payload_listener',
    ];
    
    public function validateapi(){
        Main::refresh_token(1001);
    }
    public function get_task_count(){
        $sqlunconverted = "
        SELECT
        b.task,
        COUNT(a.id) `task_count`
        FROM payloads a
        INNER JOIN payload_types b ON a.payload_type_id = b.id
        WHERE
            a.isconverted = 0
        GROUP BY
            b.task
        ";

        $sqlconverted = "
        SELECT
        COUNT(a.id) `task_count`
        FROM payloads a
        WHERE
            a.isconverted = 1
        ";

        $unconverted = collect(DB::select($sqlunconverted))->pluck('task_count', 'task')->all();
        $converted = collect(DB::select($sqlconverted))->first();

        $data = array(
            'add'=>(isset($unconverted['add'])) ? $unconverted['add'] : 0,
            'edit'=>(isset($unconverted['edit'])) ? $unconverted['edit'] : 0,
            'delete'=>(isset($unconverted['delete'])) ? $unconverted['delete'] : 0,
            'converted'=>$converted->task_count,
            'timeout'=>$this->timeout,
            'reload'=>$this->reload,
            'loop'=>$this->loop,
            'msg'=>$this->message
        );

        $this->dispatchBrowserEvent('update_task_count', $data);
    }
    public function payload_listener(){
        $payloads = PayloadModel::where('isconverted', 0)->where('isfailed', 0)->whereNotIn('payload_type_id', [1002]);
        
        $count = $payloads->count();
        if($count > 0){
            $this->timeout = 500;
            $data = $payloads->first();
            $zohopayload = json_decode($data->payload)[0]->payload;
            
            if($data->payload_type_id == 1003 || $data->payload_type_id == 1004){
                
                $created_at = Carbon::parse($zohopayload->createdTime)->format('Y-m-d H:i:s');
                $due_date = Carbon::parse($zohopayload->dueDate)->format('Y-m-d H:i:s');
                $required_date = (isset($zohopayload->cf->cf_required_date)) ? Carbon::parse($zohopayload->cf->cf_required_date)->format('Y-m-d H:i:s') : null;
                $closed_date = (isset($zohopayload->closedTime)) ? Carbon::parse($zohopayload->closedTime)->format('Y-m-d H:i:s') : null;
                // dd($zohopayload);
                $data = [
                    'ticketNumber'=>$zohopayload->ticketNumber,
                    'subject'=>$zohopayload->subject,
                    'status'=>$zohopayload->status,
                    'createdTime'=>$created_at,
                    'category'=>$zohopayload->category,
                    'subCategory'=>$zohopayload->subCategory,
                    'dueDate'=>$due_date,
                    'accountId'=>$due_date,
                    'dueDate'=>$due_date,
                    'accountId'=>$zohopayload->accountId,
                    'cf_floor'=>(isset($zohopayload->cf->cf_floor)) ? $zohopayload->cf->cf_floor : null,
                    'cf_service_coverage'=>(isset($zohopayload->cf->cf_service_coverage)) ? $zohopayload->cf->cf_service_coverage : null,
                    'cf_required_date'=>$required_date,
                    'cf_requester'=>(isset($zohopayload->cf->cf_service_coverage)) ? $zohopayload->cf->cf_service_coverage : null,
                    'cf_room_name'=>(isset($zohopayload->cf->cf_room_name)) ? $zohopayload->cf->cf_room_name : null,
                    'cf_purpose'=>(isset($zohopayload->cf->cf_purpose)) ? $zohopayload->cf->cf_purpose : null,
                    'agent_id'=>isset($zohopayload->assignee->id) ? $zohopayload->assignee->id : 1000,
                    'closedTime'=>$closed_date,
                    'departmentId'=>$zohopayload->departmentId,
                    'cf_root_cause'=>(isset($zohopayload->cf->cf_root_cause_1)) ? $zohopayload->cf->cf_root_cause_1 : null,
                    // 'accountName'=>$zohopayload->account->accountName,
                    // 'ticketOwner'=>$zohopayload->assignee->firstName." ".$zohopayload->assignee->lastName,
                ];

                // dd($data);
                $ticket = ZohoDeskTicketModel::updateOrCreate(['id'=>$zohopayload->id], $data);
                
                if($ticket){
                    
                    PayloadModel::where('id', $payloads->first()->id)->update(['isconverted'=>1]);
                    
                    if($payloads->first()->payload_type_id == 1003){
                        $this->message = "Added Ticket Number: ".$zohopayload->ticketNumber;
                    }else{
                        $this->message = "Update Ticket Number: ".$zohopayload->ticketNumber;
                    }
                }else{
                    PayloadModel::where('id', $payloads->first()->id)->update(['isfailed'=>1]);
                    $this->reload = 1;
                }
            }elseif($data->payload_type_id == 1001){
                
                $retval = $this->create_service_report($zohopayload);
                if($retval->code == '3000'){
                    
                    // dd($zohopayload);
                    $this->message = "Add Service Report";
                    PayloadModel::where('id', $payloads->first()->id)->update(['isconverted'=>1]);
                }else{
                    $this->message = "Error Converting Ticket";
                    PayloadModel::where('id', $payloads->first()->id)->update(['isconverted'=>1]);
                }
            }elseif($data->payload_type_id == 1008){
                $ticket = ZohoDeskTicketModel::where('id',$zohopayload->id)->update([
                    'isdelete'=>1
                ]);
                $this->message = "Deleting Ticket";
                PayloadModel::where('id', $payloads->first()->id)->update(['isconverted'=>1]);
            }    
        }else{
            $this->message = "Waiting for Queue...";
            $this->timeout = 5000;
        }

        $this->loop++;
        $this->get_task_count();    
    }
    public function create_service_report($data){
        $build = Main::buildapiurl(1012, ['include'=>'contacts,assignee,departments,products'], ['351081000048847001']);
        
        // dd($build);
        // dd($data);
        // dd($build['headers']);

        $apicon = new \GuzzleHttp\Client([
            'headers'=>$build['headers'],
            'http_errors' => false,
        ]);

        $response = $apicon->request('get', $build['query'], [
            'verify'=>false,
        ]);

        
        $statuscode = $response->getStatusCode();
        if($statuscode !== 401){
            
            $response = json_decode($response->getBody());

            
            $data = [
                /* Ticket Number */
                'Ticket_Number'=>$response->ticketNumber,
                'Services_AM_Email'=>'default@gmail.com',
                /* CLIENT INFO */
                'Client_Name'=>isset($response->contact->account->accountName) ? $response->contact->account->accountName : "<Blank>",
                'Floor'=>isset($response->cf->cf_floor) ? $response->cf->cf_floor : "<Blank>",
                'Room_Name'=>isset($response->cf->cf_room_name) ? $response->cf->cf_room_name : " <Blank>",
                'Site_Location'=>isset($response->cf->cf_location_1) ? $response->cf->cf_location_1 : "<Blank>",
                /* CONTACT NAME */
                'Contact_Name'=>[
                    'first_name'=>$response->contact->firstName,
                    'last_name'=>$response->contact->lastName,
                ],
                'Phone_Number'=>isset($response->contact->mobile) ? $response->contact->mobile : "0",
                'Email'=>$response->contact->email,
                'Purpose'=>isset($response->cf->cf_contract_type) ? $response->cf->cf_contract_type : "<Blank>",
                'SOR'=>isset($response->cf->cf_swo_no) ? $response->cf->cf_swo_no : "<Blank>",
                /* ENGINEER */
                'Engineer'=>[[
                    'Name'=>[
                        'first_name'=>$response->assignee->firstName,
                        'last_name'=>$response->assignee->lastName
                    ],
                    'Division'=>'<Blank>',
                    'Department'=>'<Blank>',
                ]],
                /* Time */
                'Start_Time'=>'01-01-1970 00:00',
                'End_Time'=>'01-01-1970 00:00',
                /* EQUIPMENT DETAILS */
                'Equipment_Details'=>[[
                    'Brand'=>(isset($response->product->productName)) ? $response->product->productName : "<Blank>",
                    'PN'=>(isset($response->cf->cf_service_coverage)) ? $response->cf->cf_part_dongle_system_id : "<Blank>",
                    'SN'=>(isset($response->cf->cf_serial_number)) ? $response->cf->cf_serial_number : "N/A",
                    'SC'=>(isset($response->cf->cf_service_coverage)) ? $response->cf->cf_service_coverage : "N/A",
                    'Remarks'=>"Working",
                ]],
                /* Description */
                'Issue_Request'=>isset($response->cf->cf_purpose) ? $response->cf->cf_purpose : "<Blank>",
                'Action_Taken'=>"<Blank>",
                'Findings'=>"<Blank>",
                'Root_Cause'=>"<Blank>",
                'Recommendation'=>"<Blank>",
                'Case_Status'=>'Work In Progress',
                'Received_By'=>[
                    'first_name'=>'<Blank>',
                    'last_name'=>'<Blank>',
                ],
                'Date_Time'=>'01-01-1970 00:00'
            ];
            
            $response = $apicon->post("https://creator.zoho.com/api/v2/ezabelita_fe_silvano/service-report/form/Onsite_Activity", [
                'verify'=>false,
                'body'=>json_encode(array(
                    'data'=>$data
                ))
            ]);

            $response = json_decode($response->getBody(), 'JSON_PRETTY_PRINT');

            dd($response);


            return $response;
        }else{
            $this->validateapi();
        }
    }
    public function render()
    {
        $this->validateapi();
        return view('livewire.listener-queue');
    }
}
