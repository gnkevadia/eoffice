<?php
/**
 * FeedBack Master Emailtemplate
 * Manage CRUD for the FeedBack
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedBack;
use App\Library\Common;
use Illuminate\Http\Request;
use Lang;

class FeedBackController extends Controller
{
    public function __construct()
    {
        $this->objModel = new FeedBack;
        Common::defineDynamicConstant('feedback');
    }
	/*** Default Method for the controller
     * List of the FeedBack
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
                'name.required' => 'Please specify name',
                'name.unique' => 'code already exists',
                'file.required' => 'Please specify Photo Image',
                'file.mimes' => 'Invalid File Extension. The supported file extensions is mp4,png,jpg,jpeg',
                'file.max' => 'File size should be less than 2 MB'
            ];
        $regxvalidator = [
                'name' => 'required',
                'file' => 'required_if:id,null|max:2048|mimes:mp4,png,jpg,jpeg'
            ];

        $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'16','path'=>'images/feedback/', 'predefine'=>'', 'except'=>'file_exist');

        if ($request->isMethod('post')) {
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
                'name.required' => 'Please specify name',
                'name.unique' => 'code already exists',
                'file.required' => 'Please specify Photo Image',
                'file.max' => 'File size should be less than 2 MB'
            ];
            $regxvalidator = [
                'name' => 'required',
                'file' => 'required_if:id,null|max:2048'
            ];

            $arrFile = array('name'=>'media_file','type'=>'file','resize'=>'16','path'=>'images/feedback/', 'predefine'=>'', 'except'=>'file_exist', 'existing'=>$data->media_file);

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
}
