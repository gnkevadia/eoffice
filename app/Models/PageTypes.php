<?php
/**
 * PagePageTypes Model
 * Manage CRUD for the PagePageTypes
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PageTypes extends Model
{
    /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAll()
    {   
        return PageTypes::where(['deleted' => 0])
            ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
            ->get();
    }

    /**     
    * Returns count of records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getOne($id)
    {   
        return PageTypes::where(['id' => $id])->first();
    }

    /**     
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteAll($ids,$arrUpdate)
    {     
        return PageTypes::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteOne($id,$arrUpdate)
    {     
        return PageTypes::where('id', $id)->update($arrUpdate);
    }


    /**     
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2019
    */
    function bulkUpdate($ids,$arrUpdate)
    {     
        return PageTypes::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Update specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function updateOne($id,$arrUpdate)
    {     
        return PageTypes::where('id', $id)->update($arrUpdate);
    }

    /**     
    * Returns contry details based on id
    *
    * @author ATL
    * @since Jan 2019
    */
    function getCountByCriteria($id = null, $criteria)
    {   
        if($id != null){
            return PageTypes::where($criteria)->where('id', '<>',  $id )->count();
        }else{
            return PageTypes::where($criteria)->count();    
        }
        
    }

    /**     
    * Returns all records to export
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAllToExport()
    {   
        return PageTypes::where(['deleted' => 0])
            ->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'))
            ->get()
            ->toArray();
    }
}
