<?php
/**
 * PageTypes Master PageTypes
 * Manage CRUD for the PageTypes
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PageTypes;
use Validator;
use App\Library\Common;
use Session;
use DB;
class PageTypesController extends Controller
{
    public function __construct()
    {
        $this->objModel = new PageTypes;
        Common::defineDynamicConstant('pagetype');
    }
    /**
     * Default Method for the controller
     * List of the Typese
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
	 * Create PageTypes using this method
	 * Add page-types
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function add(Request $request){
        $messages = [
            'name.required' => 'Please specify Pagetype Name',
            'name.unique' => 'Pagetype Name already exists',
            'name.regex' => 'Pagetype Name cannot have character other than a-z AND A-Z',
            'icon.required' => 'Please specify Pagetype icon',
        ];
    
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:menu_types,name,1,deleted',
                'icon' => 'required'
            ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        
        return view(RENDER_URL.'.add');
    }
	/**
	 * Edit PageTypes using this method
	 * Update page-types
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function edit(Request $request, $id = null){
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Pagetype Name',
                'name.unique' => 'Pagetype Name already exists',
                'name.regex' => 'Pagetype Name cannot have character other than a-z AND A-Z',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:menu_types,name,'.$request->id.',id,deleted,0',
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
	 * Delete PageTypes using this method
	 * Remove pagetypes by checking dependancy
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function delete(Request $request){
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
	/**
     * Toggle Gift using this method
     * Active/InActive gift status
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