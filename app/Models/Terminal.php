<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class Terminal extends Model
{
    protected $table = 'terminal';
    protected $fillable = ['code', 'zip_code', 'terminal', 'gas_brand', 'store_address', 'nos_of_pump', 'unleaded', 'midgrede','premium', 'diesel','year','states','amount','g_a_amount'];

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Terminal::query();
        
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
        return Terminal::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return Terminal::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    function deleteOne($id,$arrUpdate)
    {     
        return Terminal::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return Terminal::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }  

    public function updateOne($id, $arrUpdate)
    {
        return Terminal::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return Terminal::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Terminal::where($criteria)->count();
        }
    }

    public static function getAllToExport()
    {
        return Terminal::where(['deleted' => 0])
                ->select('name as Name', 'controller_name as ControllerName', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    public function getModuleRights()
    {
        return Terminal::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }
}
