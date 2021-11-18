<?php
namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\UserModuleModel;
use App\Models\UserSubModuleModel;
use App\Models\ZohoApiModel;
use App\Models\ParametersModel;
use App\Models\ScopeModel;
use App\Models\SystemSetupModel;
use App\Models\ZohoDeskAgentDeptModel;
use App\Models\ZohoDeskAgentModel;
use App\Models\ZohoAuthModel;

use Carbon\Carbon;

class Main {
    public function getmodules($user_id, $module_display){
        $sql = "
        SELECT
        a.*,
        b.description,
        b.route,
        b.icon,
        IFNULL(c.module_count, 0) `sub_module_count`
        FROM
        user_modules a
        INNER JOIN modules b ON a.module_id = b.id
        LEFT OUTER JOIN 
        (
            SELECT
            x.module_id,
            COUNT(x.id) `module_count`
            FROM sub_modules x
            GROUP BY
                x.module_id
        ) c ON b.id = c.module_id
        WHERE
            b.id <> 1000 AND
            b.isactive = 1 AND
            b.isdelete = 0 AND
            a.selected = 1 AND
            a.user_id = ?
        ORDER BY
            b.sorter
        ";

        return collect(DB::select($sql, [$user_id]));
    }
    public function getsubmodules($user_id){
        $usersubmodules = UserModuleModel::from('user_sub_modules as a');
        $usersubmodules = $usersubmodules->join('sub_modules as b', 'a.sub_module_id', 'b.id');
        $usersubmodules = $usersubmodules->where('a.user_id', $user_id);
        $usersubmodules = $usersubmodules->where('b.isactive', 1);
        $usersubmodules = $usersubmodules->where('b.isdelete', 0);
        $usersubmodules = $usersubmodules->orderBy('b.sorter');

        return $usersubmodules->get();
    }
    public static function apiauthenticate($zoho_auth){
        $apis = ZohoApiModel::from('zoho_api as a')
                    ->join('api_methods as b', 'a.api_method_id', 'b.id')
                    ->where('a.isauth', 1)
                    ->where('a.zoho_auth_id', $zoho_auth)
                    ->select('a.*', 'b.method')
                    ->firstOrFail();
        $params = ParametersModel::where('zoho_api_id', $apis->id)->where('isactive', 1)->where('isdelete', 0)->get();
        $scopes = ScopeModel::where('isactive', 1)
                    ->where('isdelete', 0)
                    ->where('id', '<>', 1000)
                    ->where('zoho_auth_id', $zoho_auth)
                    ->get();
        $systemsetup = SystemSetupModel::first()->toArray();
        $apiauth = ZohoAuthModel::where('id', $apis->zoho_auth_id)->first()->toArray();
        $query = (strpos($apis->url, '?') !== false) ? $apis->url."&" : $apis->url."?";
        $zoho_scope = "";

       
        if($params->count() > 0){
            foreach($params as $param){
                if($param->params_type_id == 1004){
                    if($param->id !== $params->last()->id){
                        $query .= $param->params_key."=".$param->params_value."&";
                    }else{
                        $query .= $param->params_key."=".$param->params_value;
                    }
                }
            }
        }

        if($scopes->count() > 0){
            foreach($scopes as $scope){
                if($scope->id !== $scopes->last()->id){
                    $zoho_scope .= $scope->zoho_scope.","; 
                }else{
                    $zoho_scope .= $scope->zoho_scope; 
                }
            }
        }

        if($apiauth !== null){
            foreach($apiauth as $setup => $key){
                $query = str_replace("@".$setup, $key, $query);
            }
         }

        if($systemsetup !== null){
           foreach($systemsetup as $setup => $key){
               $query = str_replace("@".$setup, $key, $query);
           }
        }

        $query = str_replace("@scopes", $zoho_scope, $query);

        session(['apiredirect'=>URL::current()]);
        
        return $query;
    }
    public static function getapicode($code, $zoho_auth){
        $apis = ZohoApiModel::from('zoho_api as a')
                    ->join('api_methods as b', 'a.api_method_id', 'b.id')
                    ->where('a.iscode', 1)
                    ->where('a.zoho_auth_id', $zoho_auth)
                    ->select('a.*', 'b.method')
                    ->firstOrFail();
        $params = ParametersModel::where('zoho_api_id', $apis->id)->where('isactive', 1)->where('isdelete', 0)->get();
        $apiauth = ZohoAuthModel::where('id', $apis->zoho_auth_id)->first()->toArray();
        $systemsetup = SystemSetupModel::first()->toArray();
        $query = (strpos($apis->url, '?') !== false) ? $apis->url."&" : $apis->url."?";

        if($params->count() > 0){
            foreach($params as $param){
                if($param->params_type_id == 1004){
                    if($param->id !== $params->last()->id){
                        $query .= $param->params_key."=".$param->params_value."&";
                    }else{
                        $query .= $param->params_key."=".$param->params_value;
                    }
                }
            }
        }
        
        $query = str_replace("@code", $code, $query);

        if($apiauth !== null){
            foreach($apiauth as $setup => $key){
                $query = str_replace("@".$setup, $key, $query);
                
            }  
        }

        if($systemsetup !== null){
            foreach($systemsetup as $setup => $key){
                $query = str_replace("@".$setup, $key, $query);
                
            }  
        }

        $apicon = new \GuzzleHttp\Client([
            'http_errors' => false,
        ]);

        $response = $apicon->request($apis->method, $query, [
            'verify'=>false
        ]);

        $response = json_decode($response->getBody());
        
        return $response;
    }
    public static function validate_token($zoho_auth){
        $systemsetup = SystemSetupModel::firstOrFail();
        $apiauth = ZohoAuthModel::where('id', $zoho_auth)->first();

        if(Carbon::now()->lt($apiauth->expires_in) !== false){
            $apis = ZohoApiModel::from('zoho_api as a')
                    ->join('api_methods as b', 'a.api_method_id', 'b.id')
                    ->where('a.isrefresh', 1)
                    ->where('a.zoho_auth_id', $zoho_auth)
                    ->select('a.*', 'b.method')
                    ->firstOrFail();
            $params = ParametersModel::where('zoho_api_id', $apis->id)->where('isactive', 1)->where('isdelete', 0)->get();
            $scopes = ScopeModel::where('isactive', 1)->where('isdelete', 0)->where('id', '<>', 1000)->where('zoho_auth_id', $zoho_auth)->get();
            $query = (strpos($apis->url, '?') !== false) ? $apis->url."&" : $apis->url."?";
            $systemsetup = $systemsetup->toArray();
            $apiauth = $apiauth->toArray();
            $zoho_scope = "";

            if($params->count() > 0){
                foreach($params as $param){
                    if($param->params_type_id == 1004){
                        if($param->id !== $params->last()->id){
                            $query .= $param->params_key."=".$param->params_value."&";
                        }else{
                            $query .= $param->params_key."=".$param->params_value;
                        }
                    }
                }
            }

            if($scopes->count() > 0){
                foreach($scopes as $scope){
                    if($scope->id !== $scopes->last()->id){
                        $zoho_scope .= $scope->zoho_scope.","; 
                    }else{
                        $zoho_scope .= $scope->zoho_scope; 
                    }
                }
            }
    
            if($apiauth !== null){
                foreach($apiauth as $setup => $key){
                    $query = str_replace("@".$setup, $key, $query);
                }
            }
    
            if($systemsetup !== null){
                foreach($systemsetup as $setup => $key){
                    $query = str_replace("@".$setup, $key, $query);
                }
            }

            $query = str_replace("@scopes", $zoho_scope, $query);

            $apicon = new \GuzzleHttp\Client([
                'http_errors' => false,
            ]);
    
            $response = $apicon->request($apis->method, $query, [
                'verify'=>false
            ]);
    
            $response = json_decode($response->getBody());

            
            if(!isset($reponse->error)){
                ZohoAuthModel::where('id', $zoho_auth)->update([
                    'access_token'=>$response->access_token,
                    'expires_in'=>Carbon::now()->addSeconds($response->expires_in)
                ]);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function refresh_token($zoho_auth){
        $systemsetup = SystemSetupModel::firstOrFail();
        $apiauth = ZohoAuthModel::where('id', $zoho_auth)->first();
        $diff = now()->diffInSeconds(Carbon::parse($apiauth->expires_in), false);
        
        if($diff > 0 && $diff <= 300){
            
            $apis = ZohoApiModel::from('zoho_api as a')->where('a.zoho_auth_id', $zoho_auth)
                    ->join('api_methods as b', 'b.id', 'a.api_method_id')
                    ->where('a.isrefresh', 1)
                    ->select('a.*', 'b.method')
                    ->first();
            $params = ParametersModel::where('zoho_api_id', $apis->id)->where('isactive', 1)->where('isdelete', 0)->get();
            $query = (strpos($apis->url, '?') !== false) ? $apis->url."&" : $apis->url."?";
            $apiauth = $apiauth->toArray();
            
            if($params->count() > 0){
                foreach($params as $param){
                    if($param->params_type_id == 1004){
                        if($param->id !== $params->last()->id){
                            $query .= $param->params_key."=".$param->params_value."&";
                        }else{
                            $query .= $param->params_key."=".$param->params_value;
                        }
                    }
                }
            }

            if($apiauth !== null){
                foreach($apiauth as $auth => $key){
                    $query = str_replace("@".$auth, $key, $query);
                }
            }

            if($systemsetup !== null){
                foreach($systemsetup as $setup => $key){
                    $query = str_replace("@".$setup, $key, $query);
                }
            }
            
            $apicon = new \GuzzleHttp\Client([
                'http_errors' => false,
            ]);
    
            $response = $apicon->request($apis->method, $query, [
                'verify'=>false
            ]);

            $response = json_decode($response->getBody());

            if(!isset($reponse->error)){
                ZohoAuthModel::where('id', $zoho_auth)->update([
                    'access_token'=>$response->access_token,
                    'expires_in'=>Carbon::now()->addSeconds($response->expires_in)
                ]);
                return true;
            }else{
                return false;
            }

        }elseif($diff <= 0){
            $query = Main::apiauthenticate(1001);
            return redirect($query);
        }else{
            return true;
        }
    }
    public static function getapidata($apicode, $addtlparam = null){
        $apis = ZohoApiModel::from('zoho_api as a')
                    ->join('api_methods as b', 'a.api_method_id', 'b.id')
                    ->where('a.id', $apicode)
                    ->select('a.*', 'b.method')
                    ->firstOrFail();
        $params = ParametersModel::where('zoho_api_id', $apis->id)->where('isactive', 1)->where('isdelete', 0)->get();
        $query = (strpos($apis->url, '?') !== false) ? $apis->url."&" : $apis->url."?";
        $systemsetup = SystemSetupModel::first()->toArray();
        $apiauth = ZohoAuthModel::where('id', $apis->zoho_auth_id)->first()->toArray();

        $query_params = 0;
        if($params->count() > 0){
            foreach($params as $param){
                if($param->params_type_id == 1004){
                    $query_params = 1;
                    if($param->id !== $params->last()->id){
                        $query .= $param->params_key."=".$param->params_value."&";
                    }else{
                        $query .= $param->params_key."=".$param->params_value;
                    }
                }elseif($param->params_type_id == 1002){
                    if($apiauth !== null){
                        $param_value = $param->params_value;
                        foreach($apiauth as $setup => $key){
                            $param_value = str_replace("@".$setup, $key, $param_value);
                        }
                        $headers[$param->params_key] = $param_value;
                    }
                }
            }
        }

        if($addtlparam !== null){
            $query = ($query_params == 1) ? $query."&" : $query;
            foreach($addtlparam as $param => $key){
                if(collect($addtlparam)->last() !== $key){
                    $query .= $param."=".$key."&";
                }else{
                    $query .= $param."=".$key;
                }
            }
        }

        if($apiauth !== null){
            foreach($apiauth as $setup => $key){
                $query = str_replace("@".$setup, $key, $query);
            }
        }

        if($systemsetup !== null){
            foreach($systemsetup as $setup => $key){
                $query = str_replace("@".$setup, $key, $query);
            }
        }
        
        $apicon = new \GuzzleHttp\Client([
            'headers'=>$headers,
            'http_errors' => false,
        ]);

        $response = $apicon->request($apis->method, $query, [
            'verify'=>false
        ]);

        $response = json_decode($response->getBody());

        return $response;
    }
    public static function syncagentdept($agent_id){
        $sql = "
        INSERT INTO zoho_desk_agent_dept (desk_agent_id, desk_dept_id, selected)
        SELECT
        a.id `desk_agent_id`,
        b.id `desk_dept_id`,
        0 `selected`
        FROM zoho_desk_agent a
        INNER JOIN zoho_desk_dept b ON 1=1
        LEFT OUTER JOIN zoho_desk_agent_dept c ON
            c.desk_agent_id = a.id AND
            c.desk_dept_id = b.id
        WHERE
            c.id IS NULL AND
            a.id <> 1000 AND
            b.id <> 1000 AND
            a.id = ?
        ";

        DB::select($sql, [$agent_id]);

        return true;
    }
    public static function syncagents($response){
        if(!isset($response->error) && !isset($response->errorCode) && $response !== null){
            foreach($response->data as $agent){
                $data = [
                    'name'=>$agent->name,
                    'emailId'=>$agent->emailId,
                    'isConfirmed'=>($agent->isConfirmed === true) ? 1 : 0,
                    'status'=>($agent->status === 'ACTIVE') ? 1 : 0,
                    'roleId'=>($agent->roleId === null) ? 1000 : $agent->roleId,
                    'profileId'=>($agent->profileId === null) ? 1000 : $agent->profileId,
                    'firstName'=>$agent->firstName,
                    'lastName'=>$agent->lastName,
                    'phone'=>$agent->phone,
                    'mobile'=>$agent->mobile,
                    'aboutInfo'=>$agent->aboutInfo,
                    'extn'=>$agent->extn,
                    'countryCode'=>$agent->countryCode,
                    'rolePermissionType'=>$agent->rolePermissionType,
                    'photoURL'=>$agent->photoURL,
                    'timeZone'=>$agent->timeZone,
                    'langCode'=>$agent->langCode,
                ];

                ZohoDeskAgentModel::updateOrCreate(['id'=>$agent->id], $data);
                Main::syncagentdept($agent->id);

                if(isset($agent->associatedDepartmentIds) && count($agent->associatedDepartmentIds) > 0){
                    ZohoDeskAgentDeptModel::where('desk_agent_id', $agent->id)->update(['selected'=>0]);

                    ZohoDeskAgentDeptModel::where('desk_agent_id', $agent->id)
                        ->whereIn('desk_dept_id', $agent->associatedDepartmentIds)
                        ->update([
                            'selected'=>'1'
                        ]);
                }else{
                    ZohoDeskAgentDeptModel::where('desk_agent_id', $agent->id)->update(['selected'=>0]);
                }
            }
            return true;
        }else{
            return false;
        }
    }
    public static function buildapiurl($apicode, $addtlparam = null, $segments = null){
        $apis = ZohoApiModel::from('zoho_api as a')
                    ->join('api_methods as b', 'a.api_method_id', 'b.id')
                    ->where('a.id', $apicode)
                    ->select('a.*', 'b.method')
                    ->firstOrFail();



        $params = ParametersModel::where('zoho_api_id', $apis->id)->where('isactive', 1)->where('isdelete', 0)->get();
        $query = $apis->url;
        
        if($segments !== null){
            foreach($segments as $segment){
                
                $query .= "/".$segment;
            }
        }

        $query .= (strpos($query, '?') !== false) ? "&" : "?";

        $systemsetup = SystemSetupModel::first()->toArray();
        $apiauth = ZohoAuthModel::where('id', $apis->zoho_auth_id)->first()->toArray();

        $query_params = 0;
        if($params->count() > 0){
            foreach($params as $param){
                if($param->params_type_id == 1004){
                    $query_params = 1;
                    if($param->id !== $params->last()->id){
                        $query .= $param->params_key."=".$param->params_value."&";
                    }else{
                        $query .= $param->params_key."=".$param->params_value;
                    }
                }elseif($param->params_type_id == 1002){
                    if($apiauth !== null){
                        $param_value = $param->params_value;
                        foreach($apiauth as $setup => $key){
                            $param_value = str_replace("@".$setup, $key, $param_value);
                        }
                        $headers[$param->params_key] = $param_value;
                    }
                }
            }
        }

        if($addtlparam !== null){
            $query = ($query_params == 1) ? $query."&" : $query;
            foreach($addtlparam as $param => $key){
                if(collect($addtlparam)->last() !== $key){
                    $query .= $param."=".$key."&";
                }else{
                    $query .= $param."=".$key;
                }
            }
        }

        if($apiauth !== null){
            foreach($apiauth as $setup => $key){
                $query = str_replace("@".$setup, $key, $query);
            }
        }

        if($systemsetup !== null){
            foreach($systemsetup as $setup => $key){
                $query = str_replace("@".$setup, $key, $query);
            }
        }

        return [
            'query'=>$query,
            'headers'=>(isset($headers)) ? $headers : false
        ];
    }
}