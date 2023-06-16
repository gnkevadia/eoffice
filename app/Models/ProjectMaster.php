<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        return ProjectMaster::join('users','users.id','=','projectmaster.manager')->where('projectmaster.deleted' , 0)->select('projectmaster.*','users.name as manager')->get();
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
   
}
