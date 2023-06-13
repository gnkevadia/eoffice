<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        return Department::where('department.deleted' , 0)->get();
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
