<?php
/**
 * Role Master Role
 * Manage CRUD for the Role
 *  
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Module;
use App\Library\Common;
use Illuminate\Http\Request;
// use Lang;
use Illuminate\Support\Facades\Lang;
// use DB;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $objModel;
    public function __construct()
    {
        $this->objModel = new Role;
        Common::defineDynamicConstant('role');
    }
    
    public function index(Request $request)
    {   
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
    
    public function add(Request $request)
    {

        $messages = [
            'name.required' => 'Please specify Module Name',
            'name.unique' => 'Module Name already exists',
            'name.regex' => 'Module Name cannot have character other than a-z AND A-Z',
        ];
    
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:modules,name,1,deleted',
            ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add');
    }
   
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Module Name',
                'name.unique' => 'Module Name already exists',
                'name.regex' => 'Module Name cannot have character other than a-z AND A-Z',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:modules,name,'.$request->id.',id,deleted,0',
            ];
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }

    public function view(Request $request, $id = null)
    {
        $dbRoles = new Role();
        $roleDetails = $dbRoles->getOne($id);
        $dbModules = new Module();
        $moduelsRights = $dbModules->getModuleRights();
        if (isset($roleDetails) && !empty($roleDetails)) {
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                $data = $request->input();
                //Parent all module permission check and uncheck code
                $rightsData = DB::table('rights')->where('status','1')->where('deleted','0')->pluck('id');
                $rightsId = array();
                if (isset($data['allCheck']) && $data['allCheck']=='checked') {
                    foreach ($rightsData as $key => $value) {
                        $rightsId[] = ''.$value.'';
                    }
                    $arrUpdate['rights'] = join(",",$rightsId);
                    $arrUpdate['allCheck']=1;
                    $dbRoles->updateOne($id,$arrUpdate);
                    return redirect('/admin/role/view/'.$id)->with('flash_message_success10', 'Module Permission updated successfully');
                } elseif (!isset($data['allCheck'])) {
                    $totalCount = count($rightsData);
                    $count = count(explode(',',$roleDetails->rights));
                    if ($totalCount==$count) {
                        $arrUpdate['rights'] = '';
                        $arrUpdate['allCheck'] = 0;
                        $dbRoles->updateOne($id,$arrUpdate);
                        return redirect('/admin/role/view/'.$id)->with('flash_message_success10', 'Module Permission updated successfully');
                    }
                }
                $userDetails = DB::table('users')->where('role_id',$id)->get();
                $arrRoleDiff = array_merge(array_diff(explode(",",$roleDetails->rights),$data['rights']), array_diff($data['rights'],explode(",",$roleDetails->rights)));
                $arrSubRights = $arrAddRights = array();
                if (isset($arrRoleDiff) && !empty($arrRoleDiff)) {
                    foreach ($arrRoleDiff as $keyDiff => $valDiff) {
                        if (!in_array($valDiff, $data['rights'])) {
                            $arrSubRights[] = $valDiff;
                        }
                        if (!in_array($valDiff, explode(",",$roleDetails->rights))) {
                            $arrAddRights[] = $valDiff;
                        }
                    }
                }
                if (isset($userDetails) && !empty($userDetails)) {
                    foreach ($userDetails as $keyUser => $valUser) {
                        if ($valUser->rights != '') {
                            $arrFilteredRights = array_diff(explode(",",$valUser->rights), $arrSubRights);
                            $arrFilteredFinalRights = array_merge($arrAddRights , $arrFilteredRights);
                            $arrUpdateUser['rights'] = join(",",$arrFilteredFinalRights);
                            $dbUsers->updateOne($valUser->id,$arrUpdateUser);
                        }
                    }
                }
                $arrUpdate['rights'] = join(",",$data['rights']);
                $dbRoles->updateOne($id,$arrUpdate);
                return redirect('/admin/role/view/'.$id)->with('flash_message_success10', 'Module Permission updated successfully');
            }
            return view('admin.role.view', compact('roleDetails','moduelsRights'));
        } else {
            return redirect('/admin/role')->with('flash_message_error10', 'Invalid argument supplied');
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
