<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Features;
use App\Library\Common;
use App\Models\ProjectMaster;
use App\Models\Priority;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Facades\Session;

class FeaturesController extends Controller
{
    protected $objModel;
    public function __construct()
    {
        $this->objModel = new Features();
        Common::defineDynamicConstant('features');
    }

    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }

    public function add(Request $request)
    {
        $project = new ProjectMaster();
        $arrproject = $project->getAll();
        $priority =  Priority::get();
        $dbDepartment = new Department();
        $id  = Session::get('company_id');
        $arrDepartment = $dbDepartment->getAll(null, $id);
        $messages = [
            'Project.required' => 'Please select Module Name',
            'name.required' => 'Please specify Rights',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'name.unique' => 'Rights already exists for selected Module',
            'description.required' => 'Please specify Description',
            'description.regex' => 'Name cannot have character other than a-z AND A-Z',
        ];
        $regxvalidator = [
            'name' => 'required',
            'description' => 'required',
        ];
        if ($request->isMethod('post')) {
            if (Session::get('superAdmin')) {
            } else {
                $request->merge(["company_id" => Session::get('company_id')]);
            }
            if(Session::get('manager')){
                $request->merge(["department_id" => Session::get('department_id')]);
                $request->merge(["manager" => Session::get('id')]);
            }
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, null, null, $arrExpect);
        } else {
            if (session()->has('superAdmin')) {
                $companys = new Company();
                $companyData = $companys->getAll();
                return view(RENDER_URL . '.add', compact('arrproject', 'priority', 'companyData'));
            }
            return view(RENDER_URL . '.add', compact('arrproject', 'priority','arrDepartment'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $project = new ProjectMaster();
        $arrproject = $project->getAll();
        $priority =  Priority::get();
        $dbDepartment = new Department();
        $departmentid  = Session::get('company_id');
        $arrDepartment = $dbDepartment->getAll(null, $departmentid);
        $messages = [
            'Project.required' => 'Please select Module Name',
            'name.required' => 'Please specify Name',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'name.unique' => 'Rights already exists for selected Module',
            'description.required' => 'Please specify Description',
            'priority.required' => 'Please specify Priority',
            'description.regex' => 'Name cannot have character other than a-z AND A-Z',
        ];
        $regxvalidator = [
            'name' => 'required',
            'description' => 'required',
            'priority' => 'required',
        ];
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            if (session()->has('superAdmin')) {
                $companys = new Company();
                $companyData = $companys->getAll();
                if (empty($data['department_id'])) {
                    $data['department_id'] = '0';
                }
                return view(RENDER_URL . '.edit', compact('data', 'arrproject', 'priority', 'companyData'));
            }
            return view(RENDER_URL . '.edit', compact('data', 'arrproject', 'priority','arrDepartment'));
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
