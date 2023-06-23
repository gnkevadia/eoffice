<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\Users;
use App\Library\Common;
use App\Models\Company;
use App\Models\Department;
use App\Models\Features;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectMasterController extends Controller
{
    protected $objModel;
    public function __construct()
    {
        $this->objModel = new ProjectMaster();
        Common::defineDynamicConstant('project');
    }
    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }

    public function add(Request $request)
    {

        if ($request->isMethod('post')) {
            if (Session::get('manager')) {
                $request->merge(["manager" => Session::get('id')]);
                $request->merge(["company_id" => Session::get('company_id')]);
                $request->merge(["department_id" => Session::get('department_id')]);
            }
            if (Session::get('sub_admin')) {
                $request->merge(["manager" => Session::get('id')]);
                $request->merge(["company_id" => Session::get('company_id')]);
            }
            $messages = [
                'name.required' => 'Please Enter Name',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
                // 'manager.required' => 'Please Enter Manager Name',
                'start_date.required' => 'Please Enter Start Date',
                'end_date.required' => 'Please Enter End Date',
            ];

            $regxvalidator = [
                'name' => 'required|regex:/^[a-zA-Z ]*$/',
                // 'manager' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ];
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            $request['start_date'] = date('Y-m-d H:i:s');
            $request['end_date'] = date('Y-m-d H:i:s');
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, null, null, $arrExpect);
        } else {
            $dbDepartment = new Department();
            $id  = Session::get('company_id');
            $arrDepartment = $dbDepartment->getAll(null, $id);

            $users = new Users();
            $settings = Session::get('settings');
            if (Session::get('superAdmin')) {
                $data = ['role_id' => $settings['MANAGER']];
                $managerData = $users->getAll(null, $data);
            } else {
                $data = ['role_id' => $settings['MANAGER'], 'company_id' => Session::get('company_id')];
                $managerData = $users->getAll(null, $data);
            }
            if (session()->has('superAdmin')) {
                $companys = new Company();
                $companyData = $companys->getAll();
                return view(RENDER_URL . '.add', compact('managerData', 'companyData', 'arrDepartment'));
            }
            return view(RENDER_URL . '.add', compact('managerData', 'arrDepartment'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

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
                'manager' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ];
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            $request['start_date'] = date('Y-m-d H:i:s');
            $request['end_date'] = date('Y-m-d H:i:s');
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            $dbDepartment = new Department();
            $id  = Session::get('company_id');
            $arrDepartment = $dbDepartment->getAll(null, $id);
            $department = new Users();
            $departmentData = $department->getAll();
            $users = new Users();
            $settings = Session::get('settings');
            if (Session::get('superAdmin')) {
                $datarole = ['role_id' => $settings['MANAGER']];
                $managerData = $users->getAll(null, $datarole);
            } else {
                $datarole = ['role_id' => $settings['MANAGER'], 'company_id' => Session::get('company_id')];
                $managerData = $users->getAll(null, $datarole);
            }
            if (session()->has('superAdmin')) {
                $companys = new Company();
                $companyData = $companys->getAll();
                if (empty($data['department_id'])) {
                    $data['department_id'] = '0';
                }
                return view(RENDER_URL . '.edit', compact('data', 'managerData', 'companyData', 'arrDepartment'));
            }
            return view(RENDER_URL . '.edit', compact('data', 'arrDepartment'));
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

    public function getProject(Request $request)
    {
        if ($request->ajax()) {
            $id = $request['id'];
            $companyId = $request['company_id'];
            if (!empty($companyId)) {
                $companyId = $request['company_id'];
            } else {
                $companyId = Session::get('company_id');
            }
            $getManager = new ProjectMaster();
            $managers = $getManager->getById($id, $companyId);
            return json_encode($managers);
        }
    }
    public function getfeatures(Request $request)
    {
        if ($request->ajax()) {
            $id = $request['id'];
            $companyId = $request['company_id'];
            if (!empty($companyId)) {
                $companyId = $request['company_id'];
            } else {
                $companyId = Session::get('company_id');
            }
            $getManager = new Features();
            $managers = $getManager->getById($id, $companyId);
            return json_encode($managers);
        }
    }
}
