<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Features;
use App\Library\Common;
use App\Models\ProjectMaster;

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
        $project =  ProjectMaster::get();
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
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrExpect);
        } else {
            // return view('admin.Features.add', compact('project'));
            return view(RENDER_URL . '.add', compact('project'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $project =  ProjectMaster::get();
        $messages = [
            'Project.required' => 'Please select Module Name',
            'name.required' => 'Please specify Name',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'name.unique' => 'Rights already exists for selected Module',
            'description.required' => 'Please specify Description',
            'Pryority.required' => 'Please specify Pryority',
            'description.regex' => 'Name cannot have character other than a-z AND A-Z',
        ];
        $regxvalidator = [
            'name' => 'required',
            'description' => 'required',
            'Pryority' => 'required',
        ];
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            return view(RENDER_URL . '.edit', compact('data', 'project'));
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
