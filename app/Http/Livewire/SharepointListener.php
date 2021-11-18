<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\ZohoDeskTicketModel;
use App\Models\SharepointAuth;
use App\Models\SharepointApi;
use App\Models\SystemSetupModel;


class SharepointListener extends Component
{
    public $loop = 0;
    public $timeout = 2000;
    public $reload = 0;
    public $message = "Connecting to Database ";

    protected $listeners = [
        'update_task_count',
        'sharepoint_listener'
    ];
    public function update_task_count()
    {
        $sql = "
        SELECT
        x.tasks,
        SUM(x.count) `count`
        FROM
        (
            SELECT
            'add_tickets' `tasks`,
            COUNT(*) `count`
            FROM zoho_tickets a
            WHERE
                a.isupload = 0 AND
                a.isdelete = 0
            UNION ALL
            SELECT
            'delete' `tasks`,
            COUNT(*) `count`
            FROM zoho_tickets a
            WHERE
                a.isupload = 1 AND
                a.isdelete = 1 AND
                a.isuploaddelete = 0
            UNION ALL
            SELECT
            'add_attach' `tasks`,
            COUNT(*) `count`
            FROM payloads a
            WHERE
                a.isconverted = 0 AND
                a.payload_type_id IN (1010, 1011)
            UNION ALL
            SELECT
            'delete' `tasks`,
            COUNT(*) `count`
            FROM payloads a
            WHERE
                a.isconverted = 0 AND
                a.payload_type_id IN (1012)
        ) as x
        GROUP BY
            x.tasks
        ";

        $unconverted = collect(DB::select($sql))->pluck('count', 'tasks');

        $data = array(
            'add_tickets'=>(isset($unconverted['add_tickets'])) ? $unconverted['add_tickets'] : 0,
            'add_attach'=>(isset($unconverted['add_attach'])) ? $unconverted['add_attach'] : 0,
            'delete'=>(isset($unconverted['delete'])) ? $unconverted['delete'] : 0,
            'timeout'=>$this->timeout,
            'reload'=>$this->reload,
            'loop'=>$this->loop,
            'msg'=>$this->message
        );

        $this->dispatchBrowserEvent('update_task_count', $data);
    }
    public function sharepoint_listener()
    {
        $sharepoint = SharepointAuth::first();
        $sql = "
        SELECT
        a.*,
        b.name
        FROM zoho_tickets a
        INNER JOIN zoho_desk_dept b ON a.departmentId = b.id
        WHERE
            a.isupload = 0
        LIMIT 1
        ";

        $result = collect(DB::select($sql));
        
        if($result->count() > 0){
            $api = SharepointApi::where('id', 1002)->first();
            $api_add = SharepointApi::where('id', 1003)->first();
            $body_format = json_decode($api_add->body);
            $header = json_decode($api->header);
            $header->Authorization = str_replace("@accesscode", $sharepoint->access_token, $header->Authorization);

            $apicon = new \GuzzleHttp\Client([
                'headers'=>(array) $header,
                'http_errors' => false,
            ]);

            $url = str_replace("@foldername", $sharepoint->ticket_folder, $api->url);
            
            foreach($result as $row){
                try{
                    $ticket_url = $url."?\$filter=TicketNumber eq ".$row->ticketNumber;
                    $response = $apicon->request('get', $ticket_url, [
                        'verify'=>false
                    ]);
                    
                
                    if($response->getStatusCode() === 401){
                        $this->get_token();
                        $this->sharepoint_listener();
                    }else{
                        $response = json_decode($response->getBody());
                        if(count($response->d->results) == 0){
                            
                            $format = $body_format;
                            $format->{'TicketNumber'} = strval($row->ticketNumber);
                            $format->{'Department'} = $row->name;

                            $response = $apicon->request('post', $url, [
                                'verify'=>false,
                                'body'=>json_encode($format)
                            ]);
                            
                            $response = json_decode($response->getBody());

                            if(isset($response->d)){
                                ZohodeskTicketModel::where('id',$row->id)->update(['isupload'=>1]);
                                $this->message = "Ticket ".$row->ticketNumber." successully created!";
                            }
                        }else{
                            ZohodeskTicketModel::where('id',$row->id)->update(['isupload'=>1]);
                            $this->message = "Ticket ".$row->ticketNumber." already existed!";
                        }
                    }

                }catch(\Exception $e){
                    dd($e);
                }
            }
        }

        
        $this->loop++;
        $this->update_task_count();
    }
    public function get_token(){
        $api = SharepointApi::where('id', 1001)->first();
        $auth = SharepointAuth::first();
        $body = json_decode($api->body);
        $header = json_decode($api->header);

        $body->client_id = $auth->client_id;
        $body->client_secret = $auth->client_secret;
        $body->resource = $auth->resource;

        $apicon = new \GuzzleHttp\Client([
            'headers'=>(array) $header,
            'http_errors' => false,
        ]);

        $response = $apicon->request('get', $api->url, [
            'verify'=>false,
            'form_params'=>(array) $body
        ]);

        $response = json_decode($response->getBody());
        if(isset($response->access_token)){
            $auth->update(['access_token'=>$response->access_token]);
            return true;
        }else{
            return false;
        }
    }
    public function render()
    {
        return view('livewire.sharepoint-listener');
    }
}
