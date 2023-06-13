<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectMaster;

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
        $data =  ProjectMaster::join('features_master', 'projectmaster.id', '=', 'features_master.project')->where('features_master.deleted' , 0)->select('features_master.*', 'projectmaster.name as project')->get();
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
}
