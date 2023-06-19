<?php
/**
 * City Model
 * Manage CRUD for the City
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class City extends Model
{
    protected $table = 'city';
    /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {   
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        // $query = Inclusion::query();
        
        // if (!empty($orderby)) {
        //     $query->orderBy($orderby);
        // } else {
        //     $query->orderBy('id', 'desc');
        // }

        // if (!empty($where)) {
        //     $query->where($where);
        // }

        return City::where(['city.deleted' => 0])
            ->join('states','states.id','=','city.state_id')
            ->join('countries','countries.id','=','states.id')
            ->select('city.*', DB::raw('CASE WHEN city.status = 1 THEN "Active" ELSE "Inactive" END as status'), 'countries.nicename as country', 'states.states_name as state')           
            ->whereRaw($dynamicWhere)
            ->get();
    }

    /**     
    * Returns records by cityname and state id
    *
    * @author ATL
    * @since Jan 2019
    */
    function getCityByNameAndStateId($name, $stateId, $limit)
    {   
        return City::where(['deleted' => 0])
            ->select('id','name')
            ->where('state_id',$stateId)
            ->where('name', 'like', '%' . $name . '%')
            ->limit($limit)->get()->toArray();
    }

    /**     
    * Returns records based on name and limit
    *
    * @author ATL
    * @since Jan 2019
    */
    function getCityByName($name, $limit)
    {   
        return City::where(['deleted' => 0])
            ->select('id','name')
            ->where('name', 'like', '%' . $name . '%')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**     
    * Returns count of records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getAllCount($strWhere)
    {   
        $sqlCntCityDetails = "SELECT count(*) AS cntCity	
            FROM city AS city 
            LEFT JOIN states AS states ON states.id = city.state_id 
            WHERE (city.deleted = '0')".$strWhere;
        return  DB::select($sqlCntCityDetails);
    }

    /**     
    * Returns count of records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getOne($id)
    {   
        return City::where(['id' => $id])->first();
        // return City::join('states', 'states.id', '=', 'city.state_id')
        //             ->leftjoin('countries', 'countries.id', '=', 'states.country_id')
        //             ->select('city.*','states.name as state','countries.name as country')
        //             ->where(['city.id' => $id])
        //             ->first();
    }

    /**     
    * Returns records based on query params
    *
    * @author ATL
    * @since Jan 2019
    */
    function selectQuery($where, $order, $limitStart, $limitEnd)
    {   
        $sqlCityDetails = 
        "SELECT 
            city.id as id,city.name as name,states.name as statename,city.country_id as countryid ,countries.name as countryname,
            (
                CASE 
                    WHEN (city.status = 1) THEN 'Active'
                    ELSE 'Inactive'
                END
            ) AS status 
        FROM city AS city
        LEFT JOIN states AS states ON states.id = city.state_id
        LEFT JOIN countries AS countries ON countries.id = states.country_id
        WHERE (city.deleted = '0') ".$where."
        ORDER BY ".$order." LIMIT ".$limitStart.",".$limitEnd;           
        return DB::select($sqlCityDetails);                        
    }

      /**     
    * Returns all records
    *
    * @author ATL
    * @since Jan 2019
    */
    function getCityByLimit($limit)
    {   
        return City::where(['deleted' => 0])->limit($limit)->get();
    }

    /**     
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteAll($ids,$arrUpdate)
    {     
        return City::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    /**     
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function deleteOne($id,$arrUpdate)
    {     
        return City::where('id', $id)->update($arrUpdate);
    }


    /**     
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2019
    */
    function bulkUpdate($ids,$arrUpdate)
    {     
        return City::whereIn('id', explode(',',$ids))->update($arrUpdate);
    }

    function getcity() {
        // return City::where(['deleted' => 0])->where(['status' => 1,'state_id' => 101])->get();
        return City::where(['deleted' => 0])->where(['status' => 1])->get();       

    }

    /**     
    * Update specific record
    *
    * @author ATL
    * @since Jan 2019
    */
    function updateOne($id,$arrUpdate)
    {     
        return City::where('id', $id)->update($arrUpdate);
    }
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    function getCityByStateId($stateId)
    {
        return City::join('states', 'states.id', '=', 'city.state_id')
        ->select('city.name','city.id')
        ->where("city.state_id",$stateId)
        ->groupBy('city.name')
        ->get()
        ->toArray();
    }

    function getFromId($id)
    {
        return City::where(['id' => $id,'deleted' => 0,'status' => 1])->select('name')->first();
    }
    function getFromName($name)
    {
        return City::where(['name' => $name,'deleted' => 0,'status' => 1])->select('*')->first();
    }
}