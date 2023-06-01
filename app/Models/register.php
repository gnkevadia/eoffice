<?php
/**
 * Register Model
 * Manage CRUD for the Register
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Register extends Model
{
    protected $table = 'register';

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

        $query = Register::query();
        
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

    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getOne($id)
    {
        return Register::where(['id' => $id])->first();
    }

    /**
    * Delete specific records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteAll($ids, $arrUpdate)
    {
        return Register::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Delete specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function deleteOne($id, $arrUpdate)
    {
        return Register::where('id', $id)->update($arrUpdate);
    }


    /**
    * Update records in bulk
    *
    * @author ATL
    * @since Jan 2020
    */
    public function bulkUpdate($ids, $arrUpdate)
    {
        return Register::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    /**
    * Update specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function updateOne($id, $arrUpdate)
    {
        return Register::where('id', $id)->update($arrUpdate);
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
            return Register::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return Register::where($criteria)->count();
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
        return Register::where(['deleted' => 0])
                ->select('name as Name', DB::raw('CASE WHEN status = 1 THEN "Active" ELSE "Inactive" END as Status'));
    }
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function additionalOperation($additopnalOperation)
    {
        if(!empty($additopnalOperation)){
            if (isset($additopnalOperation['tier_id']) && !empty($additopnalOperation['tier_id'])) {
                foreach ($additopnalOperation['tier_id'] as $keyCity => $valCity) {
                    
                    DB::table('package_tier')
                    ->updateOrInsert(
                        ['package_id' => $additopnalOperation['package_id'], 'tier_id' => $valCity],
                        ['package_id' => $additopnalOperation['package_id'], 'tier_id' => $valCity, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => Session('id'), 'updated_by' => Session('id')]
                    );
                    $packageTierId = DB::table('package_tier')->where('package_id', $additopnalOperation['package_id'])->where('tier_id', $valCity)->select('id')->first();
                    
                    DB::table('package_tier_days')
                        ->updateOrInsert(
                            ['package_tier_id' => $packageTierId->id],
                            [
                                'package_tier_id' => $packageTierId->id,

                                'normal_morning_actual_price' => $additopnalOperation['normal_morning_actual_price'][$keyCity],
                                'normal_morning_discount_price' => $additopnalOperation['normal_morning_discount_price'][$keyCity],
                                // 'prime_morning_actual_price' => $additopnalOperation['prime_morning_actual_price'][$keyCity],
                                //'prime_morning_discount_price' => $additopnalOperation['prime_morning_discount_price'][$keyCity],
                                'morning_active' => $additopnalOperation['morning_active'][$keyCity],

                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'created_by' => Session('id'),
                                'updated_by' => Session('id')
                            ]
                        );
                }
            }
            if (isset($additopnalOperation['addon_name']) && !empty($additopnalOperation['addon_name'])) {
                foreach ($additopnalOperation['addon_name'] as $keyCity => $valCity) {
                    DB::table('package_addon')
                    ->updateOrInsert(
                        ['package_id' => $additopnalOperation['package_id'], 'id' => @$additopnalOperation['addon_id'][$keyCity]],
                        ['package_id' => $additopnalOperation['package_id'], 'addon_name' => $valCity, 'addon_price' => $additopnalOperation['addon_price'][$keyCity], 'addon_description' => $additopnalOperation['addon_description'][$keyCity], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => Session('id'), 'updated_by' => Session('id')]
                    );
                    $addonId = \Illuminate\Support\Facades\DB::getPdo()->lastInsertId();
                    if(isset($additopnalOperation['addonfile'][$keyCity]) && !empty($additopnalOperation['addonfile'][$keyCity])){
                        foreach ($additopnalOperation['addonfile'][$keyCity] as $keyFile => $valFile) {
                            $extension = $valFile->getClientOriginalExtension();
                            $file_name  = rand().time().'.'.$extension;
                            if(in_array($extension,array('png','jpg','jpeg','bmp','pdf'))){
                                $valFile->move(public_path('files/package_addon/'), $file_name);
                            }

                            if(empty($addonId)){
                                $addonId = @$additopnalOperation['addon_id'][$keyCity];
                            }
        
                            DB::table('package_addon_files')
                            ->insert(
                                ['name' => $file_name, 'package_addon_id' => $addonId,'created_at' => date('Y-m-d H:i:s')]
                            );
                        }
                    }
                }
            }
        }
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageCity($id)
    {
        return DB::table('package_city')->where(['package_id' => $id])->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getCityDatePackage($packageId,$cityId)
    {
        return DB::table('package_city')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->where(['package_id' => $packageId,'city_id' => $cityId])->where('package_date','>=',date('Y-m-d'))->select('city_date_package.*')->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageTier($id)
    {
        return DB::table('package_tier')->where(['package_id' => $id])->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getTierDaysPackage($packageId,$cityId)
    {
        return DB::table('package_tier')->join('package_tier_days', 'package_tier_days.package_tier_id', '=', 'package_tier.id')->where(['package_id' => $packageId,'tier_id' => $cityId])->select('package_tier_days.*')->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageAddon($id)
    {
        return DB::table('package_addon')->where(['package_id' => $id])->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getAddonPackageFiles($packageId,$cityId)
    {
        return DB::table('package_addon')->join('package_addon_files', 'package_addon_files.package_addon_id', '=', 'package_addon.id')->where(['package_id' => $packageId,'package_addon_id' => $cityId])->select('package_addon_files.*')->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageDetails()
    {
        return DB::table('package')->join('package_city', 'package.id', '=', 'package_city.package_id')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->join('city', 'city.id', '=', 'package_city.city_id')->join('team', 'team.city_id', '=', 'city.id')->where('package.status','=','1')->where('package_date','>=',date('Y-m-d'))->select('*','city.name as cityname','package.name as packagename')->get();
    }
    /**
    * Returns specific record
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getPackageDateDetails($orderby=null, $where=array(), $dynamicWhere='')
    {
        return DB::table('package')->join('package_city', 'package.id', '=', 'package_city.package_id')->join('city_date_package', 'city_date_package.package_city_id', '=', 'package_city.id')->join('city', 'city.id', '=', 'package_city.city_id')->where('package_date','>=',date('Y-m-d'))->whereRaw($dynamicWhere)->select('*','city.name as cityname','package.name as packagename')->orderBy('city_date_package.package_date')->get();
    }
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getAllPackages($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Register::query();
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
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function retrivePackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1 ";
        }

        $query = Register::query();
        
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
    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getDateCityPackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Register::query();
        
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

    /**
    * Returns all records
    *
    * @author ATL
    * @since Jan 2020
    */
    public function getDateCityInventoryPackage($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = Register::query();
        
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
