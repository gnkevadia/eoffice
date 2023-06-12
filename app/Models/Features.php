<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return Features::get();
    }
}
