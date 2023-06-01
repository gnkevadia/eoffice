<?php
/**
 * Terminal Master Emailtemplate
 * Manage CRUD for the Terminal
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Library\Common;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Imports\InventoryImport;
use App\Models\BrandStatesStatistics;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Inventory;
        Common::defineDynamicConstant('inventory');
    }
	
    public function index(Request $request)
    {   
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
	
    public function import(Request $request)
    {
        $messages = [
            'file.required' => 'Please upload file',
            'file.mimes' => 'Invalid File Extension. The supported file extensions is .csv',
            'file.max' => 'File size should be less than 2 MB',
        ];
        $regxvalidator = [
            'file' => ['required','mimes:csv,txt,xlsx','max:2048'],
        ];

        if ($request->isMethod('post')) {
            $arrFile = array('name'=>'file','path'=>'import','predefine'=>'');
            $file    = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = $arrFile['predefine']?$arrFile['predefine']:rand().time().'.'.$extension;
            $filePath  = public_path($arrFile['path']).'\\'.$file_name;

            if(in_array($extension,array('xlsx','csv','pdf'))){
                $file->move(public_path($arrFile['path']), $file_name);
            }
       
            Excel::import(new InventoryImport, $filePath);
            @unlink(public_path($arrFile['path']."/".$file_name));
        }

        return redirect('/admin/inventory');
    }
}
