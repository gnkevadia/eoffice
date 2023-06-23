<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectMaster;
use Illuminate\Support\Facades\Session;

class Features extends Model
{
    use HasFactory;
    protected $table = 'features_master';

    public function getOne($id)
    {
        return Features::where(['id' => $id])->first();
    }

    public function updateOne($id, $arrUpdate)
    {
        return Features::where('id', $id)->update($arrUpdate);
    }

    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        if (Session::get('superAdmin')) {
            $where = ['features_master.deleted' => 0];
        } else {
            $role_id = Session::get('settings');
            $where = ['features_master.deleted' => 0, 'features_master.company_id' => Session::get('company_id')];
        }
        $data =  ProjectMaster::join('features_master', 'projectmaster.id', '=', 'features_master.project')->where($where)->select('features_master.*', 'projectmaster.name as project')->get();
        return $data;
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Features::where('id', $id)->update($arrUpdate);
    }
    public function deleteAll($ids, $arrUpdate)
    {
        return Features::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        $allids = ltrim($ids, 'on,');
        return Features::whereIn('id', explode(',', $allids))->update($arrUpdate);
    }

    public function getById($id, $companyId)
    {
        $query = Features::query();
        if (!empty($id)) {
            $data =  $query->where(['company_id' => $companyId, 'project' => $id, 'deleted' => 0])->get();
        } else {
            $data = [];
        }
        return $data;
    }
}
