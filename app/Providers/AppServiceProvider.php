<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\ModuleModel;
use App\Models\SubModuleModel;

use App\Classes\Main;

use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('modules')) {
            
            //
            view()->composer('*', function ($view) {
                $userid = (isset(Auth::user()->id)) ? Auth::user()->id : false;
                $usermodules = (new Main)->getmodules($userid, 1001);
                $usersubmodules = (new Main)->getsubmodules($userid);
                if($usermodules->count() > 0){
                    foreach($usermodules as $module){
                        if($module->route == Route::getCurrentRoute()->getName()){
                            $title = $module->description;
                            $activemodule = $module->id;
                        }
                    }

                    if(!isset($title)){
                        $modulenew = ModuleModel::where('controllers', Request::segment(1))->first();
                        if(isset($modulenew)){
                            $title = ($modulenew->description) ? $modulenew->description : "Run Migration"; 
                            $activemodule = $modulenew->id;
                        }
                    }
                    
                }else{
                    $title = "Run Migration";
                }

                if($usersubmodules->count() > 0){
                    foreach($usersubmodules as $submodule){
                        if($submodule->route == Route::getCurrentRoute()->getName()){
                            $title = $submodule->description;
                            $activemodule = $submodule->module_id;
                        }
                    }

                    if(!isset($title)){
                        $submodulenew = SubModuleModel::where('controllers', Request::segment(1))->first();
                        if(isset($submodulenew)){
                            $title = ($submodulenew->description) ? $submodulenew->description : "Run Migration";
                            $activemodule = $submodule->module_id;
                        }
                    }
                }else{
                    $title = "Run Migration";
                }


                view()->share([
                    'usermodules'=>$usermodules,
                    'usersubmodules'=>$usersubmodules,
                    'title'=>(isset($title)) ? $title : "Run Migration",
                    'activemodule'=>(isset($activemodule)) ? $activemodule : 1000,
                ]);
            });

            
        }else{
            $title = "Run Migration";
            view()->share(['title'=>$title, 'usermodules'=>false, 'usersubmodules'=>false]);
        }
    }
}
