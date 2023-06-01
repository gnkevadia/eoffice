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

class Types extends Model
{
    /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAll()
    {   
        return Types::where(['deleted' => 0])
            ->select('*', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as status'))
            ->get();
    }

     /**     
    * Returns one records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getOne($id)
    {   
        return Types::where(['id' => $id])->first();
    }

   /**     
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteAll($ids,$arrUpdate)
    {     
        return Types::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteOne($id,$arrUpdate)
    {     
        return Types::where('id', $id)->update($arrUpdate);
    }

     /**     
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2019
    */
    function bulkUpdate($ids,$arrUpdate)
    {     
        return Types::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function updateOne($id,$arrUpdate)
    {     
        return Types::where('id', $id)->update($arrUpdate);
    }

}
