<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PayloadModel;
use App\Classes\Main;

class ListenerQueue extends Component
{
    public $loop = 0;
    public $add = 0;
    public $edit = 0;
    public $warning = 0;

    protected $listeners = [
        'create_service_report'=>'create_service_report',
    ];
    
    public function validateapi(){
        Main::refresh_token(1001);

        $payloads = PayloadModel::where('isconverted', 0);
        $count = $payloads->count();
        if($count > 0){
            $data = $payloads->first();
            $zohopayload = json_decode($data->payload)[0];

        }       
    }
    public function create_service_report(){
        $apicon = new \GuzzleHttp\Client([
            'headers'=>['Authorization'=>'Zoho-oauthtoken 1000.d1a1e78f0b9f354786b5b753f4ac6137.d30293961eb04093ad03c8a867aaf4a7'],
            'http_errors' => false,
        ]);

        $response = $apicon->post("http://creator.zoho.com/api/v2/ezabelita_fe_silvano/test/form/Test", [
            'verify'=>false
        ]);

        $response = json_decode($response->getBody());

        dd($response);
    }
    public function render()
    {
        $this->validateapi();
        return view('livewire.listener-queue');
    }
}
