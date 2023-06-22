<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';

    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        // return Company::join('department', 'company.department_id', '=', 'department.id')->where('company.deleted' , 0)->select('company.*', 'department.name as department_name')->get();
        return Company::where('company.deleted', 0)->get();
    }

    public function getOne($id)
    {
        return Company::join('department', 'company.department_id', '=', 'department.id')->where(['company.id' => $id, 'company.deleted' => 0])->select('company.*', 'department.name as department_name')->first();
    }
    public function updateOne($id, $arrUpdate)
    {
        return Company::where('id', $id)->update($arrUpdate);
    }
    public function deleteOne($id, $arrUpdate)
    {
        return Company::where('id', $id)->update($arrUpdate);
    }
    public function deleteAll($ids, $arrUpdate)
    {
        return Company::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        $allids = ltrim($ids, 'on,');
        return Company::whereIn('id', explode(',', $allids))->update($arrUpdate);
    }
}
