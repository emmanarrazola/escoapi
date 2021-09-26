<?php
namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UserModuleModel;
use App\Models\UserSubModuleModel;

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
}