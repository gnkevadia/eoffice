<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Features;
use App\Library\Common;

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
        if ($request->isMethod('post')) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanAddPage($this->objModel, $request, null, null, null, null, $arrExpect);
        } else {
            return view('admin.Features.add');
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanEditPage($this->objModel, $request, null, null, $id, null, null, $arrExpect);
        } else {
            return view('admin.Features.edit', compact('data'));
        }
    }
}
