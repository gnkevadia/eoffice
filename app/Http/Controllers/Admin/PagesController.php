<?php
/**
 * Page Master Page
 * Manage CRUD for the Page
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;


use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use App\Models\PageTypes;
use App\Models\Region;
use App\Models\Types;
use App\Models\Category;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;

class PagesController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new Pages;
        Common::defineDynamicConstant('pages');
    }
    /**
     * Default Method for the controller
     * List of the pages
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, 'page_id', '', '', '', $request->is_globle, '', '');
    }
    /**
     * Create Page using this method
     * Add Page
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbPageType = new PageTypes;
        $allPageType = $dbPageType->getAll();
        $dbType = new Types;
        $allType = $dbType->getAll();
        $allCategory = Common::fetchCategoryTree();
        $dbRegionType = new Region;
        $allRegionType = $dbRegionType->getAll();
        
        $messages = [
            'page_name.required' => 'Please specify name',
            'type_id.required' => 'Please select setting name',
        ];
        
        $regxvalidator = [
               'page_name' => 'required |regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/',
            ];
        $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'','path'=>'/assets/img/service/', 'predefine'=>'', 'except'=>'file_exist');    
        if ($request->isMethod('post')) {
            $data = $request->input();
            if(isset($data['tags']) && !empty($data['tags']))
            {
                $request['tags'] = implode(',',$data['tags']);
            }
            $request->merge(['alias'=>Common::slug($data['page_name'],'pages','alias')]);
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL.'.add', compact('allPageType','allType','allCategory','allRegionType'));
    }
    /**
     * Edit Page using this method
     * Update Page
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $allCategory = Common::fetchCategoryTree();
        $data = $this->objModel->getOne($id);
        $data['tags'] = explode(',',$data['tags']);
        $dbPageType = new PageTypes;
        $allPageType = $dbPageType->getAll();
        $dbType = new Types;
        $allType = $dbType->getAll();
        $dbRegionType = new Region;
        $allRegionType = $dbRegionType->getAll();

        if (isset($data) && !empty($data)) {
            $messages = [
                'page_name.required' => 'Please specify name',
                'page_name.regex' => 'Name cannot have character other than a-z,A-Z,0-9 and special character',
                'type_id.required' => 'Please specify Setting Type',
            ];

            $regxvalidator = [
                'page_name' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/',
            ];
            $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'','path'=>'images/pages/', 'predefine'=>'', 'except'=>'file_exist', 'existing'=>$data->media_file);
			unset($request['updateslug']);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                if(isset($data['tags']) && !empty($data['tags']))
                {
                    $request['tags'] = implode(',',$data['tags']);
                }
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL.'.edit', compact('data', 'allPageType','allType','allCategory','allRegionType'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Page using this method
     * Remove page by checking dependancy
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function delete(Request $request)
    {
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
   
    /**
	 * Slug for Pages using this method
	 * Unique Slug page with all data
	 *
	 * @param string $title
     * @param string $table_name
     * @param string $field_name
	 *
	 * @author ATL
	 * @since Jan 2019
	*/
    public function slug($title,$table_name,$field_name,$primary_field_name="",$primary_field_value=""){
        $slug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
        if(isset($primary_field_name) && !empty($primary_field_name)){
            $results = collect(\DB::select("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE '$slug%' AND $primary_field_name <>  $primary_field_value"))->first();
        }else{
            $results = collect(\DB::select("SELECT COUNT(*) AS NumHits FROM $table_name WHERE  $field_name  LIKE '$slug%'"))->first();
        }
        return ($results->NumHits > 0) ? ($slug . '-' . $results->NumHits) : $slug;
    }

    /**
	 * Update page slug
	 * @param string $request
	 *
	 * @author ATL
	*/
    public function updateSlug(Request $request){
        $dbPages = new Pages;
        $data = $request->input();
        if(isset($data['update_slug']) && !empty($data['update_slug'])){
            $arrUpdate['alias'] = $this->slug($data['update_alias'],'pages','alias','page_id',$data['page_id']);
            $dbPages->updateOne($data['page_id'], $arrUpdate);           
           
        }
		$arrResult['result'] = $arrUpdate['alias'];
		echo json_encode($arrResult);die;
    }
}
