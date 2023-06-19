<?php
/**
 * SettingType Master SettingType
 * Manage CRUD for the SettingType
 *
 * @author ATL
 * @since Jan 2020
 */  
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Settingtype;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;

class SettingtypeController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Settingtype;
        Common::defineDynamicConstant('settingtype');
    }
    /**
     * Default Method for the controller
     * List of the SettingType
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
     * Create SettingType using this method
     * Add module
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $messages = [
                'name.required' => 'Please specify Setting Type Name',
                'name.unique' => 'Setting Type Name already exists',
                'name.regex' => 'Setting Type Name cannot have character other than a-z AND A-Z'
            ];
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:setting_types,name,1,deleted',
            ];


        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        
        return view(RENDER_URL.'.add');
    }
    /**
     * Edit SettingType using this method
     * Update module
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
                    'name.required' => 'Please specify Setting Type Name',
                    'name.unique' => 'Setting Type Name already exists',
                    'name.regex' => 'Setting Type Name cannot have character other than a-z AND A-Z'
                ];
            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:setting_types,name,'.$request->id.',id,deleted,0',
            ];


            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete SettingType using this method
     * Remove settingtype by checking dependancy
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
     * Toggle SettingType using this method
     * Active/InActive module status
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
