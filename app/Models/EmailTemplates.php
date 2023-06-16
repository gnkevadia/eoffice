<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class EmailTemplates extends Model
{
    protected $table = 'email_templates';

    public function getAll($orderby=null, $where=array(), $dynamicWhere='')
    {
        if (empty($dynamicWhere)) {
            $dynamicWhere = " 1 = 1";
        }

        $query = EmailTemplates::query();
        
        if (!empty($orderby)) {
           $query->orderBy($orderby);
        } else {
           $query->orderBy('id', 'desc');
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->where(['email_templates.deleted' => 0])
                    ->select('email_templates.*','email_templates.name as name','email_template_types.name as templatename', DB::raw('CASE WHEN email_templates.status = 1 THEN "Active" ELSE "Inactive" END as status'))
                    ->leftJoin('email_template_types', 'email_templates.email_Template_type_id', '=', 'email_template_types.id')
                    ->whereRaw($dynamicWhere)
                    //->groupBy('email_templates.id')
                    ->get();
    }


    function getOne($id)
    {   
        return EmailTemplates::where(['id' => $id])->first();
    }

    public function deleteAll($ids, $arrUpdate)
    {
        return EmailTemplates::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }

    function deleteOne($id,$arrUpdate)
    {     
        return EmailTemplates::where('id', $id)->update($arrUpdate);
    }

    public function bulkUpdate($ids, $arrUpdate)
    {
        return EmailTemplates::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }  

    public function updateOne($id, $arrUpdate)
    {
        return EmailTemplates::where('id', $id)->update($arrUpdate);
    }

    public function getCountByCriteria($id = null, $criteria, $menuTypeId=null)
    {
        if ($id != null) {
            return EmailTemplates::where($criteria)->where('id', '<>', $id)->count();
        } else {
            return EmailTemplates::where($criteria)->count();
        }
    }

    public function parse($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;
    
            if( isset($data[$index]) ) {
                return $data[$index];
            } else {
                throw new Exception("Shortcode {$shortCode} not found in template id {$this->id}", 1);   
            }
    
        }, $this->content);
    
        return $parsed;
    }
}
