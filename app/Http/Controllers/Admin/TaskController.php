<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FeaturesController;
use Illuminate\Http\Request;
use App\Models\Task;
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
        if ($request->isMethod('post')) {
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            return Common::commanAddPage($this->objModel, $request, null, null, null, null, $arrExpect);
        } else {
            return view('admin.Task.add');
        }
    }

    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        if ($request->isMethod('post') && isset($id) && !empty($id)) {
            // $data = $
            $arrExpect = [
                'packageId', 'cmsId', 'open_in_new_tabs'
            ];
            if ($image = $request['attachment']) {
                foreach ($image as $file) {
                    $filename = time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('deiver-license-images'), $filename);
                    echo '<pre>';
                    print_r($file);
                    echo '</pre>';
                    die();
                }
            }
            return Common::commanEditPage($this->objModel, $request, null, null, $id, null, null, $arrExpect, $filename);
        } else {
            return view('admin.Task.edit', compact('data'));
        }
    }
}
