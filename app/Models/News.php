<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class News extends Model
{
    protected $table = 'news';

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = News::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['deleted' => 0])
                    ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->whereRaw($dynamicWhere)
                    ->get();
    }


    function getOne($id)
    {   
        return News::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return News::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    function deleteOne($id,$arrUpdate)
    {     
        return News::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return News::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }  

    public function updateOne($id, $arrUpdate)
    {
        return News::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return News::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return News::where($criteria)->count();
        }
    }

    public static function getAllToExport()
    {
        return News::where(['deleted' => 0])
                ->select('name as Name', 'controller_name as ControllerName', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    public function getModuleRights()
    {
        return News::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }
}
