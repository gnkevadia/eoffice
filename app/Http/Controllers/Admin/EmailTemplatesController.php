<?php
/**
 * Emailtemplate Master Emailtemplate
 * Manage CRUD for the Emailtemplate
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;
   
class EmailTemplatesController extends Controller
{
    public function __construct()
    {
        $this->objModel = new EmailTemplates;
        Common::defineDynamicConstant('email-templates');
    }
	/**
     * Default Method for the controller
     * List of the Emailtemplate
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function index(Request $request)
    {   
        return Common::commanListPage($this->objModel, 'templatename', '', '', '', $request->is_globle, '', '');
    }
	/**
     * Create Emailtemplate using this method
     * Add emailtemplate
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbEmailTemplateTypes = new EmailTemplateTypes;
        $arrSettingtype = $dbEmailTemplateTypes->getAll('name');
        $messages = [
                'name.required' => 'Please specify Name',  
                'name.regex' => 'Name cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Name already exists for selected Settingtype',
                /* 'value.regex' => 'Please enter valid Value', */
            ];
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ?!@#\$%\^\&*\)\(+=._-]*$/  | unique:settings,name,1,deleted,setting_type_id,'.$request->setting_type_id,
            ];  

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add', compact('arrSettingtype'));
    }
	/**
     * Edit Emailtemplate using this method
     * Update emailtemplate
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $dbEmailTemplateTypes = new EmailTemplateTypes;
        $arrSettingtype = $dbEmailTemplateTypes->getAll();
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
            return view(RENDER_URL.'.edit', compact('data','arrSettingtype'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Emailtemplate using this method
     * Remove emailtemplate by checking dependancy
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
     * Toggle Emailtemplate using this method
     * Active/InActive emailtemplate status
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
