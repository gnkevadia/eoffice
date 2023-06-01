<?php
/**
 * Industries Master Emailtemplate
 * Manage CRUD for the Industries
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industries;
use App\Library\Common;
use Illuminate\Http\Request;
use Lang;

class IndustriesController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Industries;
        Common::defineDynamicConstant('industries');
    }
	/*** Default Method for the controller
     * List of the Industries
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
     * Create Teammemberrole using this method
     * Add emailtemplatetype
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $messages = [
                'title.required' => 'Please specify name',
                'title.unique' => 'title already exists',
                'file.required' => 'Please specify Photo Image',
                'file.mimes' => 'Invalid File Extension. The supported file extensions is mp4,png,jpg,jpeg',
                'file.max' => 'File size should be less than 2 MB'
            ];
        $regxvalidator = [
                'title' => 'required',
                'file' => 'required_if:id,null|max:2048|mimes:mp4,png,jpg,jpeg'
            ];

        $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'16','path'=>'images/industries/', 'predefine'=>'', 'except'=>'file_exist');

        if ($request->isMethod('post')) {
            $request->merge(['alias'=>Common::slug($request['title'],'news','alias')]);
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL.'.add');
    }
	/**
     * Edit Teammemberrole using this method
     * Update emailtemplatetype
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'title.required' => 'Please specify name',
                'title.unique' => 'code already exists',
                'file.required' => 'Please specify Photo Image',
                'file.max' => 'File size should be less than 2 MB'
            ];
            $regxvalidator = [
                'title' => 'required',
                'file' => 'required_if:id,null|max:2048'
            ];
            unset($request['updateslug']);

            $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'16','path'=>'images/industries/', 'predefine'=>'', 'except'=>'file_exist', 'existing'=>$data->media_file);

            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL.'.edit', compact('data', 'arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Teammemberrole using this method
     * Remove emailtemplatetype by checking dependancy
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
     * Toggle Teammemberrole using this method
     * Active/InActive emailtemplatetype status
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
        $dbIndustries = new Industries();
        $data = $request->input();
        if(isset($data['update_slug']) && !empty($data['update_slug'])){
            $arrUpdate['alias'] = $this->slug($data['update_alias'],'industries','alias','id',$data['id']);
            $dbIndustries->updateOne($data['id'], $arrUpdate);           
           
        }
		$arrResult['result'] = $arrUpdate['alias'];
		echo json_encode($arrResult);die;
    }
}
