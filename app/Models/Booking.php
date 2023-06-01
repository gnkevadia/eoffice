<?php
/**
 * Booking Model
 * Manage CRUD for the Booking
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Booking extends Model
{
    protected $table = 'booking';

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

        $query = Booking::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }
        
        return $query->where(['deleted' => 0])
                    ->select('*', DB::raw('CASE WHEN booking.status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->whereRaw($dynamicWhere)
                    ->get();
    }

    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOne($id, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }
        $query = Booking::query();
        return $query->where(['booking.deleted' => 0])
                    ->select('*', DB::raw('CASE WHEN booking.status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->first();
    }

    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOneDynamic($dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }
        $query = Booking::query();
        return $query->where(['booking.deleted' => 0])
                    ->select('booking.*', DB::raw('CASE WHEN booking.status = 1 THEN "Active" ELSE "Inactive" END as status'),'area.name as area','package.name as package','city.name as city',DB::raw('CONCAT("WAS",LPAD(booking.id,4,"0")) as bookingid'),'package.inclusion')
                    ->join('city_date_package', 'city_date_package.id', '=', 'booking.package_plan')
                    ->join('package_city', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('package', 'package.id', '=', 'package_city.package_id')
                    ->join('city', 'city.id', '=', 'package_city.city_id')
                    ->join('area', 'area.id', '=', 'booking.area_id')                    
                    ->whereRaw($dynamicWhere)
                    ->first();
    }

    /**
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteAll($ids, $arrUpdate)
    {
        return Booking::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteOne($id, $arrUpdate)
    {
        return Booking::where('id', $id)->update($arrUpdate);
    }


    /**
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2020
    */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Booking::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function updateOne($id, $arrUpdate)
    {
        return Booking::where('id', $id)->update($arrUpdate);
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
            return Booking::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Booking::where($criteria)->count();
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
        return Booking::where(['deleted' => 0])
                ->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }
    
}
