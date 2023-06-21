<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    
    public function getRole()
    {
        return Role::where(['deleted' => 0])->get();
    }

    public function getOneRoleById($roleId)
    {
        return Role::where(['id' => $roleId])->first();
    }

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }
        
        $query = Role::query();
        if (!empty($where)) {
            $query->where($where);
        }
        $data = Session::get('settings');
        
        if(!Session::get('superAdmin')){
            $query->whereNotIn('id', [$data['SUB_ADMIN'],$data['ADMIN']]);
        }

        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }
        return $query
            ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
            ->whereRaw($dynamicWhere)
            ->get();
    }
   
    public function getOne($id)
    {
        return Role::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return Role::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Role::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return Role::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function updateOne($id, $arrUpdate)
    {
        return Role::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria)
    {
        if ($id != null) {
            return Role::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Role::where($criteria)->count();
        }
    }

    public function getAllToExport()
    {
        return Role::where(['deleted' => 0])->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }
}
