<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Users;
use App\Library\Common;
use App\Models\Company;
use Illuminate\Support\Facades\Session;

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
        $data = new Company();
        $companyData = $data->getAll();
        $messages = [
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'description.required' => 'Please specify Description',
            'description.regex' => 'Name cannot have character other than a-z AND A-Z',
        ];
        $regxvalidator = [
            'description' => 'required',
            'name' => 'required',
        ];
        if ($request->isMethod('post')) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            $role = Session::get('settings');
            if (Session('role') == $role['SUB_ADMIN']) {
                $request->merge(["company_id" => Session::get('company_id')]);
            }
            return Common::commanAddPage($this->objModel, $request,  $messages, $regxvalidator, null, null, $arrExpect);
        } else {
            $dbManager = new Users();
            $companyId = Session::get('company_id');
            $arrManager = $dbManager->getById(null, $companyId);
            if (Session::get('superAdmin')) {
                return view(RENDER_URL . '.add', compact('companyData'));
            }
            return view(RENDER_URL . '.add', compact('companyData', 'arrManager'));
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $dataCompany = new Company();
        $companyData = $dataCompany->getAll();
        $messages = [
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'description.required' => 'Please specify Description',
            'description.regex' => 'Name cannot have character other than a-z AND A-Z',
        ];
        $regxvalidator = [
            'description' => 'required',
            'name' => 'required',
        ];
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, null, null, $arrExpect);
        } else {
            $dbManager = new Users();
            $companyId = Session::get('company_id');
            $arrManager = $dbManager->getById(null, $companyId);
            if (Session::get('superAdmin')) {
                return view(RENDER_URL . '.edit', compact('data', 'companyData','arrManager'));
            }
            return view(RENDER_URL . '.edit', compact('data', 'companyData', 'arrManager'));
            // return view(RENDER_URL . '.edit', compact('data', 'companyData'));
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

    public function Manager(Request $request)
    {
        if ($request->ajax()) {
            $id = $request['id'];
            $companyId = $request['company_id'];
            if (!empty($companyId)) {
                $companyId = $request['company_id'];
            } else {
                $companyId = Session::get('company_id');
            }
            $getManager = new Users();
            $managers = $getManager->getById($id, $companyId);
            return json_encode($managers);
        }
    }
}
