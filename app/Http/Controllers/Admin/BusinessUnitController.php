<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessUnit;
use App\Library\Common;



class BusinessUnitController extends Controller
{
    protected $objModel ; 
    public function __construct()
    {
        $this->objModel = new BusinessUnit();
        Common::defineDynamicConstant('business-unit');
    }
    public function index(Request $request){
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $messages = [
                'name.required' => 'Please Enter Name',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
                'description.required' => 'Please Enter Description',
             ];
    
            $regxvalidator = [
                'name' => 'required|regex:/^[a-zA-Z ]*$/',
                'description' => 'required',
            ];
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, null, null, $arrExpect);
        } else {
            return view(RENDER_URL . '.add');
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $messages = [
                'name.required' => 'Please Enter Name',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
                'description.required' => 'Please Enter Description',
             ];
    
            $regxvalidator = [
                'name' => 'required|regex:/^[a-zA-Z ]*$/',
                'description' => 'required',
            ];
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            return view(RENDER_URL . '.edit', compact('data'));
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
