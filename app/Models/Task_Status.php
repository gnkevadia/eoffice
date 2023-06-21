<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_Status extends Model
{
    use HasFactory;
    protected $table = 'task_status';

    public function getOne($id)
    {
        return Task_Status::where(['id' => $id])->first();
    }

    public function updateOne($id, $arrUpdate)
    {
        return Task_Status::where('id', $id)->update($arrUpdate);
    }

    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        $data =  Task_Status::get();
        return $data;
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Task_Status::where('id', $id)->update($arrUpdate);
    }
    public function deleteAll($ids, $arrUpdate)
    {
        return Task_Status::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        $allids = ltrim($ids, 'on,');
        return Task_Status::whereIn('id', explode(',', $allids))->update($arrUpdate);
    }
}
