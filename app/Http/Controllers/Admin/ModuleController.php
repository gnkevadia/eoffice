<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Library\Common;
use Illuminate\Http\Request;
// use Lang;
use Illuminate\Support\Facades\Lang;

class ModuleController extends Controller
{
    protected $objModel;
    public function __construct()
    {
        $this->objModel = new Module();
        Common::defineDynamicConstant('module');
    }
   
    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
    
    public function add(Request $request)
    {
        $messages = [
                'name.required' => 'Please specify Module Name',
                'name.unique' => 'Module Name already exists',
                'name.regex' => 'Module Name cannot have character other than a-z AND A-Z',
                'controller_name.required' => 'Please specify Controller Name',
                'controller_name.regex' => 'Controller Name cannot have character other than a-z AND A-Z',
            ];
        
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:modules,name,1,deleted',
                'controller_name' => 'required|regex:/^[a-zA-Z]*$/',
            ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add');
    }
   
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Module Name',
                'name.unique' => 'Module Name already exists',
                'name.regex' => 'Module Name cannot have character other than a-z AND A-Z',
                'controller_name.required' => 'Please specify Controller Name',
                'controller_name.regex' => 'Controller Name cannot have character other than a-z AND A-Z',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:modules,name,'.$request->id.',id,deleted,0',
                'controller_name' => 'required|regex:/^[a-zA-Z]*$/',
            ];
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	
    public function delete(Request $request)
    {
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
  
    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request);
    }
}
