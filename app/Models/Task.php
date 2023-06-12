<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task_master';

    public function getOne($id)
    {
        return Task::where(['id' => $id])->first();
    }

    public function updateOne($id, $arrUpdate)
    {
        return Task::where('id', $id)->update($arrUpdate);
    }
    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
      $data =  Task::join('features_master', 'task_master.module', '=', 'features_master.id')->select('task_master.*', 'features_master.name as module')->get();
        return $data;
    }
}
