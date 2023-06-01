<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomReports;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Reports extends Model
{
    use HasFactory;
    protected $table = 'reports';

    public function CustomReports()
    {
        return $this->hasMany(CustomReports::class, 'id');
    }

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Reports::query();
        
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
        return Reports::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return Reports::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    function deleteOne($id,$arrUpdate)
    {     
        return Reports::where('id', $id)->delete($arrUpdate);
    }

    function deleteCart($id,$arrUpdate)
    {     
        return Reports::where('user_id', $id)->delete($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return Reports::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }  

    public function updateOne($id, $arrUpdate)
    {
        return Reports::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return Reports::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Reports::where($criteria)->count();
        }
    }

    public static function getAllToExport()
    {
        return Reports::where(['deleted' => 0])
                ->select('name as Name', 'controller_name as ControllerName', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    public function getModuleRights()
    {
        return Reports::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }
}
