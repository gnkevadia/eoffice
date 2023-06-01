<?php
/**
 * Types Master Types
 * Manage CRUD for the Types
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Http\Controllers\Admin;   

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Types;
use Validator;
use App\Library\Common;
use Session;
use DB;
class TypesController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Types;
        Common::defineDynamicConstant('types');
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
	 * Create Types using this method
	 * Add types
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function add(Request $request){
        $messages = [
            'name.required' => 'Please specify Types Name',
            'name.unique' => 'Types Name already exists',
            'name.regex' => 'Types Name cannot have character other than a-z AND A-Z',
        ];
    
        $regxvalidator = [
            'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:Typeses,name,1,deleted',
        ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add');
    }
	/**
	 * Edit Types using this method
	 * Update types
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
                'name.required' => 'Please specify Types Name',
                'name.uniqued' => 'Types Name already exists',
                'name.regex' => 'Types Name cannot have character other than a-z AND A-Z',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:types,name,'.$request->id.',id,deleted,0',
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
	 * Delete Type using this method
	 * Remove type by checking dependancy
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
     * Toggle Type using this method
     * Active/InActive type status
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
