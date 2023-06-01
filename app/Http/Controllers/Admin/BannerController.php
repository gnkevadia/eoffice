<?php
/**
 * Banner Master Banner
 * Manage CRUD for the Banner
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Library\Common;
use Illuminate\Http\Request;
use Lang;

class BannerController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new Banner;
        Common::defineDynamicConstant('banner');
    }
    /**
     * Default Method for the controller
     * List of the Banner
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
     * Create Banner using this method
     * Add banner
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $messages = [
                'name.required' => 'Please specify Banner',
                'name.unique' => 'Banner already exists',
                'sub_title.required' => 'Please specify Banner',
                'file.required' => 'Please specify Photo Image',
                'file.mimes' => 'Invalid File Extension. The supported file extensions is mp4,png,jpg,jpeg',
                'file.max' => 'File size should be less than 2 MB'
            ];
        
        $regxvalidator = [
                'name' => 'required | unique:banner,name',
                'sub_title' => 'required',
                'file' => 'required_if:id,null|max:2048|mimes:mp4,png,jpg,jpeg'
            ];
        $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'16','path'=>'images/banner/', 'predefine'=>'', 'except'=>'file_exist');
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL.'.add');
    }
    /**
     * Edit Banner using this method
     * Update banner
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
                'name.required' => 'Please specify Banner',
                'name.unique' => 'Banner already exists',
                'sub_title.required' => 'Please specify Banner',
                'file.required' => 'Please specify Photo Image',
                'file.mimes' => 'Invalid File Extension. The supported file extensions is mp4,png,jpg,jpeg',
                'file.max' => 'File size should be less than 2 MB'
            ];
        $regxvalidator = [
                'name' => 'required | unique:banner,name,'.$request->id.',id',
                'sub_title' => 'required',
                'file' => 'required_if:id,null|max:2048|mimes:mp4,png,jpg,jpeg'
            ];
            $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'16','path'=>'images/banner/', 'predefine'=>'', 'except'=>'file_exist', 'existing'=>$data->media_file);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL.'.edit', compact('data','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Banner using this method
     * Remove banner by checking dependancy
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
     * Toggle Banner using this method
     * Active/InActive banner status
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
