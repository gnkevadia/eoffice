<?php
/**
 * Setting Master Setting
 * Manage CRUD for the Setting
 *
 * @author ATL
 * @since Jan 2020  
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Settingtype;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Setting;
        Common::defineDynamicConstant('setting');
    }
    /**
     * Default Method for the controller
     * List of the Setting
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
     * Create Setting using this method
     * Add module
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbModule = new Settingtype;
        $arrSettingtype = $dbModule->getAll('name');
        $messages = [
                'setting_type_id.required' => 'Please select Setting Type',
                'name.required' => 'Please specify Name',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Name already exists for selected Settingtype',
                'value.required' => 'Please specify Value',
            ];
        $regxvalidator = [
                'setting_type_id' => 'required',
                'name' => 'required | regex:/^[a-zA-Z ?!@#\$%\^\&*\)\(+=._-]*$/  | unique:settings,name,1,deleted,setting_type_id,'.$request->setting_type_id,
                'value' => 'required',
            ];


        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add', compact('arrSettingtype'));
    }
    /**
     * Edit Setting using this method
     * Update module
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $dbSettingtype = new Settingtype;
        $arrSettingtype = $dbSettingtype->getAll();
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                    'setting_type_id.required' => 'Please select Setting Type',
                    'name.required' => 'Please specify Name',
                    'name.regex' => 'Name cannot have character other than a-z AND A-Z and special character.',
                    'name.unique' => 'Name already exists for selected Settingtype',
                    'value.required' => 'Please specify Value',
                ];

            $regxvalidator = [
                'setting_type_id' => 'required',
                'name' => 'required | regex:/^[a-zA-Z ?!@#\$%\^\&*\)\(+=._-]*$/  | unique:settings,name,'.$request->id.',id,deleted,0,setting_type_id,'.$request->setting_type_id,
                'value' => 'required '
             ];


            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data','arrSettingtype'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Setting using this method
     * Remove setting by checking dependancy
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
     * Toggle Setting using this method
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
