<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Users extends Model
{
    protected $table = 'users';

    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Users::query();
        $role_id = Session::get('settings');
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('users.id', 'desc');
        }
        if (!empty($where)) {
            $query->where($where);
        }
        //  elseif (Session::get('superAdmin')) {
        //     $where = ['users.deleted' => 0];
        // } elseif ($role_id['SUB_ADMIN'] == Session::get('role')) {
        //     $query->whereIn('role_id', [$role_id['MANAGER'], $role_id['USER']]);
        //     $where = ['users.deleted' => 0, 'users.company_id' => Session::get('company_id')];
        // } else {
        //     die('x');
        //     $where = ['users.deleted' => 0, 'users.company_id' => Session::get('company_id'), 'users.role_id' => $role_id['USER']];
        // }
        if (Session::get('superAdmin')) {
            $where = ['users.deleted' => 0];
        }
        if (Session::get('sub_admin')) {
            $query->whereIn('role_id', [$role_id['MANAGER'], $role_id['USER']]);
            $where = ['users.deleted' => 0, 'users.company_id' => Session::get('company_id')];
        }
        if (Session::get('manager')) {
            $where = ['users.deleted' => 0, 'users.company_id' => Session::get('company_id'), 'users.role_id' => $role_id['USER']];
        }
        // if (Session::get('user')) {
        //     $where = ['users.deleted' => 0, 'users.company_id' => Session::get('company_id'), 'users.role_id' => $role_id['USER']];
        // }
        return $query->join('roles', 'roles.id', '=', 'users.role_id')->where($where)
            ->select('users.*', 'roles.name as roleName', DB::raw('CASE WHEN users.status = 1 THEN "Active" ELSE "Inactive" END as status'))
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

    public function getCountByCriteria($id = null, $criteria, $menuTypeId = null)
    {
        if ($id != null) {
            return Users::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Users::where($criteria)->count();
        }
    }

    public function getById($id, $companyId)
    {
        $query = Users::query();

        // if (!empty($id)) {
        $rolesId = Session::get('settings');

        if (Session::get('superAdmin')) {
            $data =  $query->where(['company_id' => $id, 'role_id' => $rolesId['MANAGER'], 'deleted' => 0])->get();
        }
        if (Session::get('sub_admin')) {
            $data =  $query->where(['company_id' => $companyId, 'department_id' => $id, 'role_id' => $rolesId['MANAGER'], 'deleted' => 0])->get();
        }

        if (empty($data)) {
            $data = [];
        }
        return $data;
    }

    public function getUsersOnly()
    {
        $role_id = Session::get('settings');
        $query = Users::query();
        if (Session::get('superAdmin')) {
            $data =     $query->where(['deleted' => 0, 'role_id' => $role_id['USER']])->get();
        } else {
            $data =     $query->where(['deleted' => 0, 'company_id' => Session::get('company_id'), 'role_id' => $role_id['USER']])->get();
        }
        return $data;
    }
}
