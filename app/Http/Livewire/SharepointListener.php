<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\ZohoDeskTicketModel;
use App\Models\SharepointAuth;
use App\Models\SharepointApi;
use App\Models\SystemSetupModel;
use App\Models\PayloadModel;

use App\Classes\Main;

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
                a.payload_type_id IN (1010, 1011) AND
                a.isfailed = 0
            UNION ALL
            SELECT
            'delete' `tasks`,
            COUNT(*) `count`
            FROM payloads a
            WHERE
                a.isconverted = 0 AND
                a.payload_type_id IN (1012) AND
                a.isfailed = 0
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
    public function create_list($result)
    {
        $sharepoint = SharepointAuth::first();
        $this->timeout = 500;
        $api = SharepointApi::where('id', 1002)->first();
        $api_add = SharepointApi::where('id', 1003)->first();
        $api_update = SharepointApi::where('id', 1004)->first();
        $body_format = json_decode($api_add->body);
        $header = json_decode($api->header);
        $header->Authorization = str_replace("@accesscode", $sharepoint->access_token, $header->Authorization);

        $apicon = new \GuzzleHttp\Client([
            'headers'=>(array) $header,
            'http_errors' => false,
        ]);

        $url = str_replace("@foldername", $sharepoint->ticket_folder, $api->url);
        $row = $result->first();

        $ticket_url = $url."?\$filter=TicketNumber eq ".$row->ticketNumber;
        $response = $apicon->request('get', $ticket_url, [
            'verify'=>false
        ]);
        
        
    
        
        if($response->getStatusCode() === 401){
            $this->get_token();
            $this->sharepoint_listener();
        }else{
            try{
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
                    if(isset($response->d->results[0]->Id)){
                        // dd($url."/getbyid('".$response->d->results[0]->Id."')");
                        ZohodeskTicketModel::where('id',$row->id)->update(['isupload'=>1]);
                        $this->message = "Ticket ".$row->ticketNumber." already existed!";
                    }
                }
                return true;
            }catch(\Exception $e){
                return false;
            }
        }
    }
    public function sharepoint_listener()
    {
        Main::refresh_token(1001);

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
            try{
                $this->create_list($result);
            }catch(\Exception $e){
                $this->message = "Something went wrong!";
            }
        }else{
            $sql = "
            SELECT
            *
            FROM payloads a
            WHERE
                a.payload_type_id IN (1010,1011) AND
                a.isconverted = 0 AND
                a.isfailed = 0
            LIMIT 1
            ";
            
            $payload = collect(DB::select($sql));
            
            if($payload->count() <> 0){
                $payload = $payload->first();
                $payload_id = $payload->id;
                $payload = json_decode($payload->payload)[0]->payload;

                $attachment['href'] = $payload->href;
                $attachment['name'] = $payload->name;
                $attachment = (object) $attachment;
                $id = $payload->ticketId;
                
                $sql = "
                SELECT
                a.*,
                b.name
                FROM zoho_tickets a
                LEFT OUTER JOIN zoho_desk_dept b ON a.departmentId = b.id
                WHERE
                    a.id = ?
                ";

                $result = collect(DB::select($sql, [$id]));
   
                $endpoint = Main::buildapiurl(1012, null, [$id]);
                $apicon = new \GuzzleHttp\Client([
                    'headers'=>$endpoint['headers'],
                    'http_errors' => false,
                ]);
                
            
                $response = $apicon->request('get', $endpoint['query'], [
                    'verify'=>false
                ]);


                // dd($response->getBody()->getContents());
                if($response->getStatusCode() !== 401 && $response->getBody()->getContents() !== null){
                    $desk = json_decode($response->getBody());
                    $auth = SharepointAuth::first();
                    $api = SharepointApi::where('id', 1002)->first();
                    $body_format = json_decode($api->body);
                    $header = json_decode($api->header);
                    
                    try{
                    $header->Authorization = str_replace("@accesscode", $auth->access_token, $header->Authorization);
                    $url = str_replace("@foldername", $auth->ticket_folder, $api->url);
                    $ticket_url = $url."?\$filter=TicketNumber eq ".$result->first()->ticketNumber."&\$expand=AttachmentFiles";
                    $apisharepoint = new \GuzzleHttp\Client([
                        'headers'=>(array) $header,
                        'http_errors'=>false,
                    ]);
                    
                    $response = $apisharepoint->request('get', $ticket_url, [
                        'verify'=>false
                    ]);
                    }catch(\Exception $e){
                        dd($e);
                    }

                    
                    if($response->getStatusCode() !== 403 && $response->getStatusCode() !== 401){
                        $response = json_decode($response->getBody());
                        if(isset($response->d->results) && count($response->d->results) <> 0){
                            if(isset($desk)){
                                $this->sharepoint_upload($attachment, $header, $apicon, $auth, $payload_id, $response->d->results);
                            }
                        }else{
                            /* INSERT LIST FIRST */
                            $this->create_list($result);
                        }
                    }else{
                        $this->get_token();
                        $this->sharepoint_listener();
                    }
                }
            }else{
                $this->timeout = 2000;
                $this->message = "No Listener Activity";
            }
        }
        
        $this->loop++;
        $this->update_task_count();
    }
    public function sharepoint_upload($attachment, $header, $apicon, $auth, $payload_id = 0, $result)
    {
        $apisharepoint = new \GuzzleHttp\Client([
            'headers'=>(array) $header,
            'http_errors' => false,
        ]);
        $content = $apicon->request('get', $attachment->href,[
            'verify'=>false
        ]);
        
        $content = $content->getBody()->getContents();

        if(!isset(json_decode($content)->errorCode)){
            try{
                $api = SharepointApi::where('id', 1004)->first();
                $body_format = json_decode($api->body);
                $header = json_decode($api->header);
                $header->Authorization = str_replace("@accesscode", $auth->access_token, $header->Authorization);
                $url = str_replace("@foldername", $auth->ticket_folder, $api->url);
                $url = str_replace("@filename", $attachment->name, $url);
                $url = str_replace("@itemid", $result[0]->Id, $url);
                
                $apisharepoint = new \GuzzleHttp\Client([
                    'headers'=>(array) $header,
                    'http_errors'=>false,
                ]);
            }catch(\Exception $e){
                dd($e);
            }

            $file=$content;

            $response = $apisharepoint->request('post', $url, [
                'verify'=>false,
                'body'=>$file
            ]);

            $response = json_decode($response->getBody());
            if($payload_id !== 0){
                PayloadModel::where('id', $payload_id)->update(['isconverted'=>1]);
            }
        }else{
            // dd(json_decode($content));
            if($payload_id !== 0){
                PayloadModel::where('id', $payload_id)->update(['isfailed'=>1]);
            }
        }
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
        dd($response);
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
