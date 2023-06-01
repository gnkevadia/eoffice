<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class Inventory extends Model
{
    protected $table = 'inventory';
    protected $fillable = ['zip_code', 'year', 'states', 'amount', 'ga_amount','gas_station', 'code_total', 'gas_station_total'];

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Inventory::query();
        
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
        return Inventory::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return Inventory::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    function deleteOne($id,$arrUpdate)
    {     
        return Inventory::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return Inventory::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }  

    public function updateOne($id, $arrUpdate)
    {
        return Inventory::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return Inventory::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Inventory::where($criteria)->count();
        }
    }

    public static function getAllToExport()
    {
        return Inventory::where(['deleted' => 0])
                ->select('name as Name', 'controller_name as ControllerName', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    public function getModuleRights()
    {
        return Inventory::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }
}
