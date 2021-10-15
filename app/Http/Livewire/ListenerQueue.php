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

    public function validateapi(){
        Main::refresh_token(1001);

        $payloads = PayloadModel::where('isconverted', 0);
        $count = $payloads->count();
        if($count > 0){
            $data = $payloads->first();
            $zohopayload = json_decode($data->payload)[0];

        }

        
    }
    public function render()
    {
        $this->validateapi();
        return view('livewire.listener-queue');
    }
}
