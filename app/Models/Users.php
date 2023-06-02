<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    protected $table = 'users';

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Users::query();
        
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

    public function getOne($id)
    {
        return Users::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return Users::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function deleteOne($id, $arrUpdate)
    {
        return Users::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return Users::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    public function updateOne($id, $arrUpdate)
    {
        return Users::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return Users::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Users::where($criteria)->count();
        }
    }

    public static function getAllToExport()
    {
        return Users::where(['deleted' => 0])
                ->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }
   
    public function getPackageAddon($id)
    {
        return DB::table('package_addon')->where(['package_id' => $id])->get();
    }
   
    public function getAddonPackageFiles($packageId,$cityId)
    {
        return DB::table('package_addon')->join('package_addon_files', 'package_addon_files.package_addon_id', '=', 'package_addon.id')->where(['package_id' => $packageId,'package_addon_id' => $cityId])->select('package_addon_files.*')->get();
    }
    
    public function getPackageDetails()
    {
        return DB::table('package')->join('package_city', 'package.id', '=', 'package_city.package_id')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->join('city', 'city.id', '=', 'package_city.city_id')->join('team', 'team.city_id', '=', 'city.id')->where('package.status','=','1')->where('package_date','>=',date('Y-m-d'))->select('*','city.name as cityname','package.name as packagename')->get();
    }
    
    public function getPackageDateDetails($orderby=null, $where=array(), $dynamicWhere='')
    {
        return DB::table('package')->join('package_city', 'package.id', '=', 'package_city.package_id')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->join('city', 'city.id', '=', 'package_city.city_id')->where('package_date','>=',date('Y-m-d'))->whereRaw($dynamicWhere)->select('*','city.name as cityname','package.name as packagename')->orderBy('city_date_package.package_date')->get();
    }
   
    public function getAllPackages($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Users::query();
        if (!empty($orderby)) {
            $query->orderBy($orderby, 'asc');
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['package.deleted' => 0])
                    ->select()
                    ->get();
    }
   
    public function retrivePackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1 ";
        }

        $query = Users::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['package.deleted' => 0])
                    ->select('package.*', DB::raw('CASE WHEN package.status = 1 THEN "Active" ELSE "Inactive" END as status'), DB::raw('MiN(morning_actual_price) as actual_price'), DB::raw('MiN(morning_discount_price) as discount_price'),'city.name as cityname')
                    ->join('package_city', 'package.id', '=', 'package_city.package_id')
                    ->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('city', 'city.id', '=', 'package_city.city_id')
                    ->whereRaw($dynamicWhere)
                    ->groupBy("package.id")
                    ->first();
    }
   
    public function getDateCityPackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Users::query();
        
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return DB::table('package_city')
                    ->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('city', 'package_city.city_id', '=', 'city.id')
                    ->join('package', 'package.id', '=', 'package_city.package_id')
                    ->whereRaw($dynamicWhere)
                    ->select('city_date_package.*','city_date_package.id as citypackageid','package.activity_time','city.morning_start','city.morning_end','city.afternoon_start','city.afternoon_end','city.evening_start','city.evening_end','city.night_start','city.night_end','package.price_for_kids',DB::raw('IF(morning_active = 1 || afternoon_active = 1 || evening_active = 1 || night_active = 1, "Active", "Inactive") as entirestatus'))
                    ->orderBy('city_date_package.package_date','asc')
                    ->get();
    }

    public function getDateCityInventoryPackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Users::query();
        if (!empty($orderby)) {
            $query->orderBy($orderby);
        } else {
            $query->orderBy('package.id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return DB::table('package_city')
                    ->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')
                    ->join('city', 'package_city.city_id', '=', 'city.id')
                    ->join('package', 'package.id', '=', 'package_city.package_id')
                    ->whereRaw($dynamicWhere)
                    ->select('city_date_package.*','city_date_package.id as citypackageid','package.activity_time','city.morning_start','city.morning_end','city.afternoon_start','city.afternoon_end','city.evening_start','city.evening_end','city.night_start','city.night_end','package.price_for_kids',DB::raw('IF(morning_active = 1 || afternoon_active = 1 || evening_active = 1 || night_active = 1, "Active", "Inactive") as entirestatus'),'package.id as packageid','package.kids_start_from')
                    ->orderBy('city_date_package.package_date','asc')
                    ->get();
    }
}
