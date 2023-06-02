<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use DB;
use Illuminate\Support\Facades\DB;
class Rights extends Model
{
    public function getAll($order_by=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }
           
        $query = Rights::query();
        if (!empty($where)) {
            $query->where($where);
        }
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('rights.id', 'desc');
        }

        return $query->where(['rights.deleted' => 0])
            ->join('modules', 'rights.module_id', '=', 'modules.id')
            ->select('rights.*', 'modules.name as module', DB::raw('CASE WHEN rights.status = 1 THEN "Active" ELSE "Inactive" END as status'))
            ->whereRaw($dynamicWhere)
            ->get();
    }
    public function getOne($id)
    {
        return Rights::where(['id' => $id])->first();
    }

    
    public function deleteAll($ids, $arrUpdate)
    {
        return Rights::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Rights::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return Rights::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function updateOne($id, $arrUpdate)
    {
        return Rights::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria)
    {
        if ($id != null) {
            return Rights::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Rights::where($criteria)->count();
        }
    }

    public function getAllToExport()
    {
        return Rights::where(['right.deleted' => 0])
            ->join('module', 'right.module_id', '=', 'module.id')
            ->select('right.name as Name', 'module.name as Module', DB::raw('CASE WHEN right.status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }
}
