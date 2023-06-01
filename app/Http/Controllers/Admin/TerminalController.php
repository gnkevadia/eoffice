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
use App\Models\Terminal;
use App\Library\Common;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Imports\TerminalsImport;

class TerminalController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Terminal;
        Common::defineDynamicConstant('terminal');
    }
	/*** Default Method for the controller
     * List of the Terminal
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function index(Request $request)
    {   
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
	/**
     * Create Teammemberrole using this method
     * Add emailtemplatetype
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbTeamMemberRole = new Terminal;
        $arrSettingtype = $dbTeamMemberRole->getAll();
        $messages = [
                'code.required' => 'Please specify code',
                'code.unique' => 'code already exists',
            ];
        $regxvalidator = [
                'code' => 'required',
            ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add', compact('arrSettingtype'));
    }
	/**
     * Edit Teammemberrole using this method
     * Update emailtemplatetype
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                    'code.required' => 'Please specify code',
                    'code.unique' => 'code already exists',
                ];
            $regxvalidator = [
                'code' => 'required',
            ];

            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
    /**
     * View Teammemberrole using this method
     * View emailtemplatetype
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function view(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            
            return view(RENDER_URL.'.view', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Teammemberrole using this method
     * Remove emailtemplatetype by checking dependancy
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function delete(Request $request)
    {
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
	/**
     * Toggle Teammemberrole using this method
     * Active/InActive emailtemplatetype status
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request);
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

            if(in_array($extension,array('xlsx'))){
                $file->move(public_path($arrFile['path']), $file_name);
            }

            Excel::import(new TerminalsImport,  $filePath);
            //@unlink(public_path($arrFile['path']."/".$file_name));

        }
        return view(RENDER_URL.'.import');
    }
}
