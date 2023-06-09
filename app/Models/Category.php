<?php
/**
 * Module Model
 * Manage CRUD for the Module
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    protected $table = 'categories';
    
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Category::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('categories.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['categories.deleted' => 0])
                    ->leftjoin('categories as cat', 'cat.id', '=', 'categories.parent_id')
                    ->select('categories.*', DB::raw('CASE WHEN categories.status = 1 THEN "Active" ELSE "Inactive" END as status'), 'cat.name as parent')
                    ->whereRaw($dynamicWhere)
                    ->get();
    }

    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOne($id)
    {
        return Category::where(['id' => $id])->first();
    }

    /**
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteAll($ids, $arrUpdate)
    {
        return Category::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteOne($id, $arrUpdate)
    {
        return Category::where('id', $id)->update($arrUpdate);
    }


    /**
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2020
    */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Category::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function updateOne($id, $arrUpdate)
    {
        return Category::where('id', $id)->update($arrUpdate);
    }

    /**
    * Returns contry details based on id
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            //return Category::where($criteria)->where('id', '<>',  $id )->where('menu_type_id', '=',  $menuTypeId)->count();
            return Category::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Category::where($criteria)->count();
        }
    }

    /**
    * Returns all records to export
    *
    * @author ATL
    * @since Jan 2020
    */
    public static function getAllToExport()
    {
        return Category::where(['deleted' => 0])
                ->select('name as Name', 'controller_name as ControllerName', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }

    /**
    * Returns rights of Module
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getModuleRights()
    {
        return Category::leftJoin('rights', 'rights.module_id', '=', 'modules.id')
                        ->where(['modules.deleted' => 0])
                        ->where(['rights.deleted' => 0])
                        ->select('rights.id as rightsId', 'rights.name as rightsName', 'modules.id as moduleId', 'modules.name as moduleName')
                        //->groupBy('rights.id')
                        ->orderBy('modules.name')
                        ->orderBy('rights.name')
                        ->get();
    }
}
