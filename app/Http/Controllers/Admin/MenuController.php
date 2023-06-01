<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuTypes;
use App\Models\Rights;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
// use Lang;
use Illuminate\Support\Facades\Lang;
use App\Models\Package;
use App\Models\Pages;

class MenuController extends Controller
{   
    protected $objModel ; 
    public function __construct()
    {
        $this->objModel = new Menu();
        Common::defineDynamicConstant('menu');
    }
 
    public function index(Request $request)
    {   
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }

    public function add(Request $request)
    {
        $dbRights = new Rights();
        $rightModules = $dbRights->getAll('rights.name');

        $dbTypes = new MenuTypes();
        $rightTypes = $dbTypes->getAll('menu_types.name');

        $messages = [
                'name.required' => 'Please specify Menu Name',
                'name.unique' => 'Menu Name already exists',
                'name.regex' => 'Menu Name cannot have character other than a-z, A-Z AND -',
                'ordering.numeric' => 'ordering cannot have character other than numeric'
            ];
        
        $regxvalidator = [
                'name' => 'required|regex:/^[a-zA-Z&\- ]*$/ | unique:menus,name,1,deleted',
                'ordering' => 'numeric|nullable',
            ];
        
        $arrExpect = [
            'packageId','cmsId','open_in_new_tabs'
        ];
        
        if ($request->isMethod('post')) {
            $data = $request->input();
            if(!empty($request->open_in_new_tabs)){
                $request['open_in_new_tab'] = $request->open_in_new_tabs;
                
                if($request->open_in_new_tab == 1){
                    $request['package_cms_id'] = $request->packageId;
                }else{
                    $request['package_cms_id'] = $request->cmsId;
                }
            }
            $request->merge(['alias'=>Common::slug($request['name'],'menus','alias')]);

            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator,null,null,$arrExpect);
        }
        return view(RENDER_URL.'.add', compact('rightModules','rightTypes'));
    }
   
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        
        $dbRights = new Rights();
        $rightModules = $dbRights->getAll();

        if(!empty($data->menu_type_id)){
            $typeId = $data->menu_type_id;
            $nLevelMenus = Common::fetchMenuTree($parent = 0, $spacing = '', $userTreeArray = '', $typeId);
        }

        $dbTypes = new MenuTypes();
        $rightTypes = $dbTypes->getAll('menu_types.name');
        
        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Menu Name',
                'name.regex' => 'Menu Name cannot have character other than a-z, A-Z AND -',
                'ordering.numeric' => 'ordering cannot have character other than numeric'
        ];

            $regxvalidator = [
            'name' => 'required| regex:/^[a-zA-Z&\- ]*$/',
            'ordering' => 'numeric|nullable',
        ];
        
        $arrExpect = [
            'packageId','cmsId','open_in_new_tabs'
        ];

            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                $request['open_in_new_tab'] = $request->open_in_new_tabs;
                if ($request->open_in_new_tab == 1) {
                    $request['package_cms_id'] = $request->packageId;
                } else {
                    $request['package_cms_id'] = $request->cmsId;
                }

                $menus =  $this->objModel->where(['menus.deleted' => 0, 'alias' => $request['alias']])->first();
                if (!empty($menus)) {
                    if ($menus->alias == $request['alias'] && !empty($request['alias'])) {
                        unset($request['updateslug']);
                    } else {
                        $request->merge(['alias' => Common::slug($request['name'], 'menus', 'alias')]);
                    }
                }
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
            }
            return view(RENDER_URL.'.edit', compact('data','rightModules','rightTypes','nLevelMenus'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	
    public function delete(Request $request)
    {
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
   
    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request);
    }

    public function optionSelect(Request $request)
    {
        if ($request->isMethod('post')) {
            $dbPackage = new Package();
            $data = $request->input();
            if(!empty($data) && isset($data))
            {
                if(!empty($data['typeId'])){
                    $typeId = $data['typeId'];
                    $nLevelMenus = Common::fetchMenuTree($parent = 0, $spacing = '', $userTreeArray = '', $typeId);
                    return $nLevelMenus;
                }else{
                    if(!empty($data['selectRadio']) && $data['selectRadio'] == 1){
                        $radioList1 = $dbPackage->where(['package.deleted' => 0])->get();
                        return $radioList1;
                    }else{
                        $typeId = 2;
                        $dbPages = new Pages();
                        $radioList1 = $dbPages->where(['pages.deleted' => 0])->get();
                        return $radioList1;
                    }
                }
            }
        }
    }
    public function slug($title,$table_name,$field_name,$primary_field_name="",$primary_field_value=""){
        $slug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
        if(isset($primary_field_name) && !empty($primary_field_name)){
            $results = collect(\DB::select("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE '$slug%' AND $primary_field_name <>  $primary_field_value"))->first();
        }else{
            $results = collect(\DB::select("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE '$slug%'"))->first();
        }
        return ($results->NumHits > 0) ? ($slug . '-' . $results->NumHits) : $slug;
    }
    public function updateSlug(Request $request){
        exit('OK');
        $dbMenus = new Menu();
        $data = $request->input();
        if(isset($data['update_slug']) && !empty($data['update_slug'])){
            $arrUpdate['alias'] = $this->slug($data['update_alias'],'menus','alias','id',$data['id']);
            $dbMenus->updateOne($data['id'], $arrUpdate);           
           
        }
		$arrResult['result'] = $arrUpdate['alias'];
		echo json_encode($arrResult);die;
    }
}
