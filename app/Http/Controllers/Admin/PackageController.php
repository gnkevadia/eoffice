<?php
/**
 * Package Master Package
 * Manage CRUD for the Package
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Library\Common;
use Illuminate\Http\Request;
use Lang;
use App\Models\City;
use App\Models\Inclusion;
use App\Models\Faq;
use App\Models\Category;


class PackageController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new Package;
        Common::defineDynamicConstant('package');
    }
    /**
     * Default Method for the controller
     * List of the Package
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function index(Request $request)
    {   
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
    /**
     * Create Package using this method
     * Add package
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbCity = new City();
        $arrCity = $dbCity->getAll('name');
        $dbFaq = new Faq();
        $arrFaq = $dbFaq->getAll('question');
        $dbCategory = new Category();
        $arrCategory = $dbCategory->getAll('name');

        $messages = [
                'name.required' => 'Please specify Package',
                'name.regex' => 'Package cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Package already exists',
            ];
        
        $regxvalidator = [
                'name' => 'required',
            ];

        $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'16','path'=>'images/package/', 'predefine'=>'', 'except'=>'file_exist');
        $arrBanner = array('name'=>'banner','type'=>'file','resize'=>'16','path'=>'images/package/', 'predefine'=>'', 'except'=>'banner_exist', 'existing'=>'');
        $arrBannerMobile = array('name'=>'banner_mobile','type'=>'file','resize'=>'16','path'=>'images/package/', 'predefine'=>'', 'except'=>'banner_mobile_exist', 'existing'=>'');

        if ($request->isMethod('post')) {
        
            $request['report_title'] = json_encode($request->input('report_title'));
            $request['report_prices'] = json_encode($request->input('report_prices'));
            
            if(is_array($request->input('inclusion_ids'))){
                $request->merge(['inclusion_ids'=>join(',',$request->input('inclusion_ids'))]);
            }

            $request->merge(['date'=>date('Y-m-d',strtotime($request->input('date')))]);
            $arrExpect = array('addonfile','banner_mobile_exist','banner_mobile','banner','banner_exist');

            if (isset($arrBanner['name']) && !empty($arrBanner['name']) && $request->hasFile(str_replace('_exist','',$arrBanner['except']))) {
                $img_name = Common::resizeFile($request, $arrBanner);
                $request->merge(['banner_image'=>$img_name]);
            }

            if (isset($arrBannerMobile['name']) && !empty($arrBannerMobile['name']) && $request->hasFile(str_replace('_exist','',$arrBannerMobile['except']))) {
                $img_name = Common::resizeFile($request, $arrBannerMobile);
                $request->merge(['banner_mobile_image'=>$img_name]);
            }
        
            $request->merge(['alias'=>Common::slug($request['name'],'package','alias')]);
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile, '', $arrExpect);
        }
        return view(RENDER_URL.'.add', compact('arrCity','arrFaq','arrCategory'));
    }
    /**
     * Edit Package using this method
     * Update package
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $dbCategory = new Category();
        $arrCategory = $dbCategory->getAll('name');

        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Package',
                'name.regex' => 'Package cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Package already exists',
            ];
        
        $regxvalidator = [
                'name' => 'required',
            ];
            unset($request['updateslug']);
            $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'','path'=>'images/package/', 'predefine'=>'', 'except'=>'file_exist', 'existing'=>$data->media_file);

            $arrBanner = array('name'=>'banner','type'=>'file','resize'=>'','path'=>'images/package/', 'predefine'=>'', 'except'=>'banner_exist', 'existing'=>$data->banner_image);
            $arrBannerMobile = array('name'=>'banner_mobile','type'=>'file','resize'=>'','path'=>'images/package/', 'predefine'=>'', 'except'=>'banner_mobile_exist', 'existing'=>$data->banner_mobile_image);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                
                $additopnalOperation['package_id'] = $request->id;
                $additopnalOperation['pk_id'] = 'package_id';
                $request->merge(['date'=>date('Y-m-d',strtotime($request->input('date')))]);

                $arrExpect = array('addonfile','banner_mobile_exist','banner_mobile','banner','banner_exist');

                if (isset($arrBanner['name']) && !empty($arrBanner['name']) && $request->hasFile(str_replace('_exist','',$arrBanner['except']))) {
                    $img_name = Common::resizeFile($request, $arrBanner);
                    $request->merge(['banner_image'=>$img_name]);
                }

                if (isset($arrBannerMobile['name']) && !empty($arrBannerMobile['name']) && $request->hasFile(str_replace('_exist','',$arrBannerMobile['except']))) {
                    $img_name = Common::resizeFile($request, $arrBannerMobile);
                    $request->merge(['banner_mobile_image'=>$img_name]);
                }
                
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile, $additopnalOperation,$arrExpect);
            }
            $objModel = $this->objModel; 

            return view(RENDER_URL.'.edit', compact('data','objModel','arrFile','arrCategory'));
        } else {
            
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
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
        $dbPackage = new Package();
        $data = $request->input();
        if(isset($data['update_slug']) && !empty($data['update_slug'])){
            $arrUpdate['alias'] = $this->slug($data['update_alias'],'package','alias','id',$data['id']);
            $dbPackage->updateOne($data['id'], $arrUpdate);           
           
        }
		$arrResult['result'] = $arrUpdate['alias'];
		echo json_encode($arrResult);die;
    }
    /**
     * View Package using this method
     * View package
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function view(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $dbCity = new City();
        $arrCity = $dbCity->getAll('name');
        $dbInclusion = new Inclusion();
        $arrInclusion = $dbInclusion->getAll('name');
        $dbFaq = new Faq();
        $arrFaq = $dbFaq->getAll('question');
        $dbCategory = new Category();
        $arrCategory = $dbCategory->getAll('name');

        if (isset($data) && !empty($data)) {
            
            $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'','path'=>'images/package/', 'predefine'=>'', 'except'=>'file_exist', 'existing'=>$data->media_file);
            
            $objModel = $this->objModel; 

            return view(RENDER_URL.'.view', compact('data','objModel','arrFile','arrCity','arrInclusion','arrFaq','arrCategory'));
        } else {
            
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Package using this method
     * Remove package by checking dependancy
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
     * Toggle Package using this method
     * Active/InActive package status
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request);
    }
}
