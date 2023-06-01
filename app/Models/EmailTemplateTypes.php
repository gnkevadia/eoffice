<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class EmailTemplateTypes extends Model
{
    protected $table = 'email_template_types';

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = EmailTemplateTypes::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['deleted' => 0])
                    ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->whereRaw($dynamicWhere)
                    ->get();
    }


    function getOne($id)
    {   
        return EmailTemplateTypes::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return EmailTemplateTypes::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    function deleteOne($id,$arrUpdate)
    {     
        return EmailTemplateTypes::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return EmailTemplateTypes::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }  

    public function updateOne($id, $arrUpdate)
    {
        return EmailTemplateTypes::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            //return Category::where($criteria)->where('id', '<>',  $id )->where('menu_type_id', '=',  $menuTypeId)->count();
            return EmailTemplateTypes::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return EmailTemplateTypes::where($criteria)->count();
        }
    }

    public static function getAllToExport()
    {
        return EmailTemplateTypes::where(['deleted' => 0])
                ->select('name as Name', 'controller_name as ControllerName', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    public function getModuleRights()
    {
        return EmailTemplateTypes::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }
}
