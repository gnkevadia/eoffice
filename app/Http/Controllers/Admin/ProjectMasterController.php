<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\Users;
use App\Library\Common;
use Illuminate\Support\Facades\Session;

class ProjectMasterController extends Controller
{
    protected $objModel ; 
    public function __construct()
    {
        $this->objModel = new ProjectMaster();
        Common::defineDynamicConstant('project');
    }
   public function index(Request $request){
    return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
   }
   
   public function add(Request $request){
    if($request->isMethod('post')) {
        if (Session::get('superAdmin')) {
            $request->merge(["company_id" => Session::get('company_id')]);
        } else {
            $request->merge(["company_id" => Session::get('company_id')]);
        }
        $messages = [
            'name.required' => 'Please Enter Name',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'manager.required' => 'Please Enter Manager Name',
            'start_date.required' => 'Please Enter Start Date',
            'end_date.required' => 'Please Enter End Date',
         ];

        $regxvalidator = [
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'manager' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $arrExpect = [
            'packageId','cmsId','open_in_new_tabs'
        ];
        $request['start_date']=date('Y-m-d H:i:s');
        $request['end_date']=date('Y-m-d H:i:s');
        return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator,null,null,$arrExpect);
    }else{
        
        $users = new Users();
        $datas = $users->getAll();
        return view(RENDER_URL . '.add',compact('datas'));
    }
   }

   public function edit(Request $request, $id = null){
    $data = $this->objModel->getOne($id);
    // $data->start_date =  
    if ($request->isMethod('post') && isset($id) && !empty($id)) {
        $messages = [
            'name.required' => 'Please Enter Name',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'manager.required' => 'Please Enter Manager Name',
            'start_date.required' => 'Please Enter Start Date',
            'end_date.required' => 'Please Enter End Date',
         ];

        $regxvalidator = [
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'manager' => 'required|regex:/^[a-zA-Z ]*$/',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $arrExpect = [
            'packageId','cmsId','open_in_new_tabs'
        ];
        $request['start_date']=date('Y-m-d H:i:s');
        $request['end_date']=date('Y-m-d H:i:s');
        return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
    }else{
        $department = new Users();
        $departmentData = $department->getAll();
        return view(RENDER_URL . '.edit',compact('data'));

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
