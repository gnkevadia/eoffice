<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Department extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'department';

    public function getOne($id)
    {
        return Department::where(['id' => $id])->first();
    }

    public function updateOne($id, $arrUpdate)
    {
        return Department::where('id', $id)->update($arrUpdate);
    }
    public function getById($id)
    {
        $query = Department::query();
        if (!empty($id)) {
            $data =  $query->where(['company_id' => $id, 'deleted' => 0])->get();
        } else {
            $data = [];
        }
        return $data;
    }

    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        // $data = Department::join('business_unit', 'department.business_id', '=', 'business_unit.id')->where('department.deleted', 0)->select('department.*', 'business_unit.name as business_name')->get();
        $query = Department::query();
        if (!empty($where)) {
            $query->where(['deleted' => 0, 'company_id' => $where]);
        } else {
            $query->where(['deleted' => 0]);
        }
        if (Session::get('superAdmin')) {
            if (!empty($where)) {
                $query->where(['deleted' => 0, 'company_id' => $where]);
            } else {
                $query->where(['deleted' => 0]);
            }
        }
        $sessionRole = Session::get('settings');
        if ($sessionRole['SUB_ADMIN'] == Session::get('role')) {
            $query->where(['deleted' => 0, 'company_id' => $sessionRole['SUB_ADMIN']]);
        }
        $data = $query->get();
        return $data;
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Department::where('id', $id)->update($arrUpdate);
    }
    public function deleteAll($ids, $arrUpdate)
    {
        return Department::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        $allids = ltrim($ids, 'on,');
        return Department::whereIn('id', explode(',', $allids))->update($arrUpdate);
    }
}
