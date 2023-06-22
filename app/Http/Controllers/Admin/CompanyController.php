<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Library\Common;
use App\Models\Department;

class CompanyController extends Controller
{

    protected $objModel;
    public function __construct()
    {
        $this->objModel = new Company();
        Common::defineDynamicConstant('company');
    }
    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $messages = [
                'name.required' => 'Please Enter Name',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
                // 'department_id.required' => 'Please Select Department',
                'description.required' => 'Please Select Department',

            ];

            $regxvalidator = [
                'name' => 'required|regex:/^[a-zA-Z ]*$/',
                'description' => 'required|regex:/^[a-zA-Z ]*$/',
                // 'department_id' => 'required',
            ];
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, null, null, $arrExpect);
        } else {
            $department = new Department();
            $departmentData = $department->getAll();
            return view(RENDER_URL . '.add', compact('departmentData'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        if ($request->isMethod('post') && isset($id) && !empty($id)) {

            $messages = [
                'name.required' => 'Please Enter Name',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
                'department_id.required' => 'Please Select Department',
                'description.required' => 'Please Select Department',

            ];

            $regxvalidator = [
                'name' => 'required|regex:/^[a-zA-Z ]*$/',
                'description' => 'required|regex:/^[a-zA-Z ]*$/',
                'department_id' => 'required',
            ];
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            $department = new Department();
            $departmentData = $department->getAll();
            return view(RENDER_URL . '.edit', compact('data', 'departmentData'));
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
