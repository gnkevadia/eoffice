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
        return ProjectMaster::get();
       
    }
}
