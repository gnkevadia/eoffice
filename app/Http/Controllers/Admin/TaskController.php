<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FeaturesController;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Features;
use App\Models\Priority;
use App\Models\ProjectMaster;
use App\Models\Task_Status;
use App\Models\Users;
use Illuminate\Support\Facades\Session;
use App\Library\Common;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class TaskController extends Controller
{
    protected $objModel;
    public function __construct()
    {
        $this->objModel = new Task();
        Common::defineDynamicConstant('task');
    }

    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }

    public function add(Request $request)
    {
        $features = new features();
        $arrfeatures = $features->getAll();
        $project = new ProjectMaster();
        $arrproject = $project->getAll();
        $priority =  Priority::get();
        $taskstatus =  Task_Status::where('deleted', 0)->get();
        $users = new Users();
        $arrUsers = $users->getUsersOnly();
        $messages = [
            'Project.required' => 'Please select Module Name',
            'task.required' => 'Please specify Task',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'description.required' => 'Please specify Description',
            'description.regex' => 'Name cannot have character other than a-z AND A-Z',
            // 'Project.required' => 'Please specify Project',
            // 'features.required' => 'Please specify Features',
            'start_date.required' => 'Please specify Start Date',
            'end_date.required' => 'Please specify End Date',
            'hour_task.required' => 'Please specify Hour of Task',
        ];
        $regxvalidator = [
            // 'Project' => 'required',
            // 'features' => 'required',
            'task' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'hour_task' => 'required',
        ];
        $arrFile = array('name' => 'file', 'type' => 'image', 'path' => 'images/task/', 'predefine' => '', 'except' => 'file_exist', 'multiple_file' => true);
        if ($request->isMethod('post')) {
            if (Session::get('superAdmin')) {
            } else {
                $request->merge(["company_id" => Session::get('company_id')]);
            }
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            $request['start_date'] = date('Y-m-d H:i:s');
            $request['end_date'] = date('Y-m-d H:i:s');
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile, null, $arrExpect);
        } else {
            $dbDepartment = new Department();
            $id  = Session::get('company_id');
            $arrDepartment = $dbDepartment->getAll(null, $id);
            if (session()->has('superAdmin')) {
                $companys = new Company();
                $companyData = $companys->getAll();
                return view(RENDER_URL . '.add', compact('arrfeatures', 'arrproject', 'priority', 'arrUsers', 'taskstatus', 'companyData'));
            }
            return view(RENDER_URL . '.add', compact('arrfeatures', 'arrproject', 'priority', 'arrUsers', 'taskstatus', 'arrDepartment'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $features = new features();
        $arrfeatures = $features->getAll();
        $project = new ProjectMaster();
        $arrproject = $project->getAll();
        $priority =  Priority::get();
        $taskstatus =  Task_Status::where('deleted', 0)->get();
        $users = new Users();
        $arrusers = $users->getAll();
        $messages = [
            'Project.required' => 'Please select Module Name',
            'task.required' => 'Please specify Task',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'description.required' => 'Please specify Description',
            'description.regex' => 'Name cannot have character other than a-z AND A-Z',
            'Project.required' => 'Please specify Project',
            'features.required' => 'Please specify Features',
            'start_date.required' => 'Please specify Start Date',
            'end_date.required' => 'Please specify End Date',
        ];
        $regxvalidator = [
            'Project' => 'required',
            'features' => 'required',
            'task' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $request['start_date'] = date('Y-m-d H:i:s');
        $request['end_date'] = date('Y-m-d H:i:s');
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            $request->merge(['path' => 'images/task/']);
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            $dbDepartment = new Department();
            $id  = Session::get('company_id');
            $arrDepartment = $dbDepartment->getAll(null, $id);
            if (session()->has('superAdmin')) {
                $companys = new Company();
                $companyData = $companys->getAll();
                return view(RENDER_URL . '.edit', compact('data', 'arrfeatures', 'arrproject', 'priority', 'arrusers', 'taskstatus', 'companyData'));
            }
            return view(RENDER_URL . '.edit', compact('data', 'arrfeatures', 'arrproject', 'priority', 'arrusers', 'taskstatus', 'arrDepartment'));
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
