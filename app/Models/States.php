<?php
/**
 * States Model
 * Manage CRUD for the States
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class States extends Model
{
    protected $table = 'states';
    /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getStateByCountryId($countryId)
    {   
        return States::join('countries', 'countries.id', '=', 'states.country_id')
        ->select('states.name','states.id')
        ->where("states.country_id",$countryId)
        ->groupBy('states.name')
        ->get()
        ->toArray();
    }   
    /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAll()
    {   
        return States::where(['deleted' => 0])->get();
    }
    /**
    * Returns all records of india states
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAllIndia() {
        // return States::where(['deleted' => 0])->where(['status' => 1,'country_id' => 101])->get();
        return States::where(['deleted' => 0])->where(['status' => 1])->get();       

    }
    /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getStatesByLimit($limit)
    {   
        return States::where(['deleted' => 0])->limit($limit)->get();
    }

    /**     
    * Returns records by cityname and state id
    *
    * @author ATL
    * @since Jan 2019
    */
    function getStatesByNameAndCountryId($name, $countryId, $limit)
    {   
        return City::where(['deleted' => 0])
            ->select('id','name')
            ->where('country_id',$countryId)
            ->where('name', 'like', '%' . $name . '%')
            ->limit($limit)->get()->toArray();
    }

    /**     
    * Returns records based on name and limit
    *
    * @author ATL
    * @since Jan 2019
    */
    function getStatesByName($name, $limit)
    {   
        return City::where(['deleted' => 0])
            ->select('id','name')
            ->where('name', 'like', '%' . $name . '%')
            ->limit($limit)
            ->get()
            ->toArray();
    }    

     /**     
    * Returns records of states for index
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAllStatesName()
    {
        return States::where(['states.deleted' => 0])
            ->join('countries','countries.id','=','states.country_id')
            ->select('states.*', DB::raw('CASE WHEN states.status = 1 THEN "Active" ELSE "Inactive" END as status'),'countries.name as country')
            ->get();
    }
  
     /**     
    * Returns count of records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAllCount($strWhere)
    {   
        $sqlCntStatesDetails = "SELECT count(*) AS cntstates 
                FROM `states` AS states
                LEFT JOIN `countries` AS countries ON countries.id = states.country_id
                WHERE (states.`deleted` = '0')".$strWhere;
        return  DB::select($sqlCntStatesDetails);
    }

      /**     
    * Returns records based on query params
    *
    * @author ATL
    * @since Jan 2019
    */
    function selectQuery($where, $order, $limitStart, $limitEnd)
    {   
        $sqlstatesDetails = 'SELECT 
									states.id as id,states.name as name,countries.name as countryname,
									(
									    CASE 
									        WHEN (states.status = 1) THEN "Active"
									        ELSE "Inactive"
									    END
									) AS status 
								FROM `states` AS states
                                LEFT JOIN `countries` AS countries ON countries.id = states.country_id
                                WHERE (states.`deleted` = "0") '.$where.'
								ORDER BY '.$order.' LIMIT '.$limitStart.','.$limitEnd;
        return DB::select($sqlstatesDetails);
                    
    }

     /**     
    * Returns one  records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getOne($id)
    {   
        return States::where(['states.deleted' => 0,'states.id' => $id])->first();
        //return States::where([])->first();
    }

     /**     
    * Returns vie state
    *
    * @author ATL
    * @since Jan 2019
    */
    function getCountryByState($id)
    {   
        return States::where(['states.id' => $id])
        ->join('countries', 'countries.id', '=', 'states.country_id')
        ->select('countries.name')
        ->get()
        ->toArray();
    }

     /**     
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteAll($ids,$arrUpdate)
    {     
        return States::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteOne($id,$arrUpdate)
    {     
        return States::where('id', $id)->update($arrUpdate);
    }

     /**     
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2019
    */
    function bulkUpdate($ids,$arrUpdate)
    {     
        return States::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Update specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function updateOne($id,$arrUpdate)
    {     
        return States::where('id', $id)->update($arrUpdate);
    }

     /**     
    * export state records
    *
    * @author ATL
    * @since Jan 2019
    */
    function exportAll()
    {  
        return States::where(['states.deleted' => 0])
            ->join('countries','countries.id','=','states.country_id')
            ->select('states.name as Name','countries.name as Country',DB::raw('CASE WHEN states.status = 1 THEN "Active" ELSE "Inactive" END as Status'))
            ->get()->toArray();
    }

    function getStateByLimit($countryId,$term,$limit)
    {
        return States::where(['deleted' => 0])->select('id','name')
            ->where('country_id',$countryId)
            ->where('name', 'like', '%' . $term . '%')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    function getStates($term,$limit)
    {
        return States::where(['deleted' => 0])
            ->select('id','name')
            ->where('name', 'like', '%' . $term . '%')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    function getFromId($id)
    {
        return States::where(['id' => $id,'deleted' => 0,'status' => 1])->select('name')->first();
    }
    
    function getFromCountryId($country_id)
    {
        return States::where(['country_id' => $country_id,'deleted' => 0,'status' => 1])->select('name')->get();
    }

    function getFromName($name)
    {
        return States::where(['name' => $name,'deleted' => 0,'status' => 1])->select('*')->first();
    }
    
}
