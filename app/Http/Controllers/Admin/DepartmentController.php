<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Library\Common;

class DepartmentController extends Controller
{
    protected $objModel;
    public function __construct()
    {
        $this->objModel = new Department();
        Common::defineDynamicConstant('department');
    }

    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }

    public function add(Request $request)
    {
        // $project =  ProjectMaster::get();
        if ($request->isMethod('post')) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanAddPage($this->objModel, $request, null, null, null, null, $arrExpect);
        } else {
            return view(RENDER_URL . '.add');
            // return view(RENDER_URL.'.add', compact('project'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        // $project =  ProjectMaster::get();
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanEditPage($this->objModel, $request, null, null, $id, null, null, $arrExpect);
        } else {
            return view(RENDER_URL.'.edit', compact('data'));
            // return view('admin.Features.edit', compact('data', 'project'));
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
