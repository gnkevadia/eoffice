<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ProjectMaster extends Model
{
    use HasFactory;
    protected $table = 'projectmaster';
    public function getOne($id)
    {
        return ProjectMaster::where(['id' => $id])->first();
    }
    public function updateOne($id, $arrUpdate)
    {
        return ProjectMaster::where('id', $id)->update($arrUpdate);
    }
    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        if (Session::get('superAdmin')) {
            $where = ['projectmaster.deleted' => 0];
        } else {
            // $role_id = Session::get('settings');
            $where = ['projectmaster.deleted' => 0, 'projectmaster.company_id' => Session::get('company_id')];
        }
        $data =  ProjectMaster::join('users', 'users.id', '=', 'projectmaster.manager')->where($where)->select('projectmaster.*', 'users.name as manager')->get();
        return $data;
    }
    public function deleteOne($id, $arrUpdate)
    {
        return ProjectMaster::where('id', $id)->update($arrUpdate);
    }
    public function deleteAll($ids, $arrUpdate)
    {
        return ProjectMaster::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        $allids = ltrim($ids, 'on,');
        return ProjectMaster::whereIn('id', explode(',', $allids))->update($arrUpdate);
    }
    public function getById($id, $companyId)
    {
        $query = ProjectMaster::query();
        if (!empty($id)) {
            $data =  $query->where(['company_id' => $companyId, 'manager' => $id, 'deleted' => 0])->get();
        } else {
            $data = [];
        }
        return $data;
    }
}
