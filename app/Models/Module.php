<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use DB;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
  
    public function getAll($orderby=null, $where=array(), $dynamicWhere='', $start='', $limit='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Module::query();
        
        if (is_array($orderby) && !empty($orderby)) {
            $query->orderBy($orderby[0], $orderby[1]);
        } elseif (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        if ($start!='' && $limit!='') {
            $query->skip($start)->take($limit);
        }


        return $query->where(['deleted' => 0])
                    ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->whereRaw($dynamicWhere)
                    ->get();
    }

   
    public function getOne($id)
    {
        return Module::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return Module::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Module::where('id', $id)->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Module::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function updateOne($id, $arrUpdate)
    {
        return Module::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            //return Module::where($criteria)->where('id', '<>',  $id )->where('menu_type_id', '=',  $menuTypeId)->count();
            return Module::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Module::where($criteria)->count();
        }
    }

    public static function getAllToExport()
    {
        return Module::where(['deleted' => 0])
                ->select('name as Name', 'controller_name as ControllerName', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    public function getModuleRights()
    {
        return Module::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }
}
