<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FeaturesController;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Features;
use App\Models\Pryority;
use App\Models\ProjectMaster;

use App\Library\Common;
use Illuminate\Support\Facades\DB;

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
        
        $data =  Features::get();
        $project =  ProjectMaster::get();
        $pryority =  Pryority::get();
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
        $arrFile = array('name'=>'file','type'=>'image','path'=>'images/task/', 'predefine'=>'', 'except'=>'file_exist', 'multiple_file'=>true);
        if ($request->isMethod('post')) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            $request['start_date']=date('Y-m-d H:i:s');
            $request['end_date']=date('Y-m-d H:i:s');
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile, null, $arrExpect);
        } else {
            return view(RENDER_URL . '.add', compact('data', 'project', 'pryority'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $features =  Features::get();
        $project =  ProjectMaster::get();
        $pryority =  Pryority::get();
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
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            $request->merge(['path' => 'images/task/']);
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            return view(RENDER_URL . '.edit', compact('data', 'features', 'project', 'pryority'));
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
