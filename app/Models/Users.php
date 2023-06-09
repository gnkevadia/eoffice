<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class Users extends Model
{
    protected $table = 'users';

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Users::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('users.id', 'desc');
        }
        if (!empty($where)) {
            $query->where($where);
        }
        if(Session::get('superAdmin')){
            $where = ['users.deleted' => 0];
        }else{
            // echo '<pre>++'; print_r(Session::get('company_id')); echo '</pre>'; 
            // echo '<pre>'; print_r(Session::all()); echo '</pre>'; die();
            $role_id = Session::get('settings');
            $where = ['users.deleted' => 0,'users.company_id' => Session::get('company_id'),'users.role_id' => $role_id['USER']];
        }
        return $query->join('roles', 'roles.id', '=', 'users.role_id')->where($where)
                    ->select('users.*','roles.name as roleName', DB::raw('CASE WHEN users.status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->whereRaw($dynamicWhere)
                    ->get();
    }

    public function getOne($id)
    {
        return Users::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return Users::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Users::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return Users::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function updateOne($id, $arrUpdate)
    {
        return Users::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return Users::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Users::where($criteria)->count();
        }
    }

    
    // public function getModules(){
    //     $data = Module::where('deleted',0)->get();
    //     return $data;
    // }
}
