<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;
    protected $table = 'business_unit';
    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        return BusinessUnit::where('deleted' , 0)->get();
    }
    public function getOne($id)
    {
        return BusinessUnit::where(['id' => $id])->first();
    }
    public function updateOne($id, $arrUpdate)
    {
        return BusinessUnit::where('id', $id)->update($arrUpdate);
    }
    public function deleteOne($id, $arrUpdate)
    {
        return BusinessUnit::where('id', $id)->update($arrUpdate);
    }
    public function deleteAll($ids, $arrUpdate)
    {
        return BusinessUnit::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        $allids = ltrim($ids, 'on,');
        return BusinessUnit::whereIn('id', explode(',', $allids))->update($arrUpdate);
    }
}
