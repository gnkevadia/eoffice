<?php


namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
// use App\User;
use App\Models\Users;
use App\Models\Role;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use App\Library\Common;
use App\Models\BusinessUnit;
use App\Models\Company;
use App\Models\Department;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    protected $objModel;
    public function __construct()
    {
        $this->objModel = new Users;
        Common::defineDynamicConstant('user');
    }

    public function index(Request $request)
    {
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }

    public function add(Request $request)
    {
        $dbrole = new Role();
        $arrRole = $dbrole->getAll();
        $dbcountry = new Country();
        $arrCountry = $dbcountry->getAll();
        $dbState = new States();
        $arrState = $dbState->getAll();
        $arrCountry = $dbcountry->getAll();
        $dbBusiness = new BusinessUnit();
        $arrBusiness = $dbBusiness->getAll();
        $dbcity = new City();
        $arrCity = $dbcity->getAll();
        $dbDepartment = new Department();
        $id  = Session::get('company_id');
        $arrDepartment = $dbDepartment->getAll(null, $id);
        if (Session::get('manager')) {
            $request->merge(["company_id" => Session::get('company_id')]);
            $request->merge(["department_id" => Session::get('department_id')]);
        }
        $messages = [
            'name.required' => 'Please specify Name',
            'name.unique' => 'Name already exists',
            'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            'email.required' => 'Please specify Email',
            'password.required' => 'Please specify Passsword',
            'address1.required' => 'Please specify Address',
            'address2.required' => 'Please specify Address',
            'postal_code.required' => 'Please specify Postcode',
            'postal_code.integer' => 'Please specify Postcode in Digits',
            'country_id.required' => 'Please specify Country',
            'state_id.required' => 'Please specify State',
            'city_id.required' => 'Please specify City',
            'company_id.required' => 'Please specify Company',
            'department_id.required' => 'Please specify Department',
            // 'business_id.required' => 'Please specify Business',
            'role_id.required' => 'Please specify Role',

        ];

        $regxvalidator = [
            'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:modules,name,1,deleted',
            'email' => 'required | email',
            'password' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'postal_code' => 'required | integer',
            'country_id' => 'required ',
            'state_id' => 'required ',
            'city_id' => 'required ',
            'company_id' => 'required ',
            'department_id' => 'required ',
            // 'business_id' => 'required ',
            'role_id' => 'required ',
        ];
        $arrFile = array('name' => 'profile_photo', 'type' => 'image', 'resize' => '50', 'path' => 'images/users/', 'predefine' => '', 'except' => 'file_exist');
        if ($request->isMethod('post')) {
            $request->merge(["password" => Hash::make(trim($request->password))]);
            if (is_array($request->role_id)) {
                $request->merge(["role_id" => join(',', $request->role_id)]);
            }
            $role = Session::get('settings');
            if (Session::get('role') == $role['SUB_ADMIN']) {
                $request->merge(["company_id" => Session::get('company_id')]);
            }
            if (Session::get('superAdmin')) {
                $request->merge(["business_id" => $request['business_id']]);
            }
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        if (session()->has('superAdmin')) {
            $companys = new Company();
            $companyData = $companys->getAll();
            return view(RENDER_URL . '.add', compact('arrRole', 'arrCountry', 'arrState', 'arrCity', 'companyData', 'arrBusiness'));
        }
        return view(RENDER_URL . '.add', compact('arrRole', 'arrCountry', 'arrState', 'arrCity', 'arrDepartment'));
    }

    public function getDepartment(Request $request)
    {
        if ($request->ajax()) {
            $id = $request['id'];
            $getDepartment = new Department();
            $departments = $getDepartment->getById($id);
            return json_encode($departments);
        }
    }

    public function edit(Request $request, $id = null)
    {
        $dbrole = new Role();
        $arrRole = $dbrole->getAll();
        $dbcountry = new Country();
        $arrCountry = $dbcountry->get();
        $dbState = new States();
        $arrState = $dbState->get();
        $dbcity = new City();
        $arrCity = $dbcity->getAll();
        $dbDepartment = new Department();
        $companyId  = Session::get('company_id');
        $arrDepartment = $dbDepartment->getAll(null, $companyId);
        $dbBusiness = new BusinessUnit();
        $arrBusiness = $dbBusiness->getAll();
        $data = $this->objModel->getOne($id);
        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Name',
                'name.unique' => 'Name already exists',
                'name.regex' => 'Name cannot have character other than a-z AND A-Z',
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:users,name,' . $request->id . ',id,deleted,0',
            ];

            $arrFile = array('name' => 'profile_photo', 'type' => 'image', 'resize' => '50', 'path' => 'images/users/', 'predefine' => '', 'except' => 'file_exist', 'existing' => $data->profile_photo);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                $request->merge(["role_id" => join(',', $request->role_id)]);
                $role = Session::get('settings');
                if (Session::get('role') == $role['SUB_ADMIN']) {
                    $request->merge(["company_id" => Session::get('company_id')]);
                }
                if (Session::get('superAdmin')) {
                    $request->merge(["business_id" => $request['business_id']]);
                }
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            if (session()->has('superAdmin')) {
                $companys = new Company();
                $companyData = $companys->getAll();
                if (empty($data['department_id'])) {
                    $data['department_id'] = '0';
                }
                return view(RENDER_URL . '.edit', compact('data', 'arrCountry', 'arrRole', 'arrState', 'arrCity', 'arrFile', 'companyData', 'arrBusiness'));
            }

            return view(RENDER_URL . '.edit', compact('data', 'arrCountry', 'arrRole', 'arrState', 'arrCity', 'arrFile', 'arrDepartment'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }

    public function view(Request $request, $id = null)
    {
        $dbUsers = new Users();
        $userDetails = $dbUsers->getOne($id);
        $dbRoles = new Role;
        $roles = $dbRoles->getAll();
        $moduelsRights = $dbUsers->getModules();
        if (isset($userDetails) && !empty($userDetails)) {
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                $data = $request->input();
                $arrUpdate['rights'] = join(",", $data['rights']);
                $dbUsers->where('id', $id)->update($arrUpdate);

                return redirect('/admin/user/view/' . $id)->with('flash_message_success8', 'Module Permission updated successfully');
            }
            return view('admin.user.view', compact('userDetails', 'roles', 'moduelsRights'));
        } else {
            return redirect('/admin/user')->with('flash_message_error8', 'Invalid argument supplied');
        }
    }

    public function delete(Request $request)
    {
        $arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request);
    }

    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request, $arrTableFields);
    }

    public function export(Request $request)
    {
        $arrHeading = array('Module Name', 'Status');
        return Excel::download(new MainExport(MODELNAME, $arrHeading), 'module.xlsx');
    }

    public function myprofile(Request $request, $id = null)
    {
        // echo '<pre>'; print_r($request->all()); echo '</pre>'; die();
        if ($request->id !=  $request->session()->get('id')) {
            return redirect('admin/myprofile/' . $request->session()->get('id') . '')->with('flash_message_error8', 'Invalid argument supplied');
        }
        if ($request->session()->get('role') == 3) {
            return redirect('admin/dashboard');
        } else {
            $dbrole = new Role;
            $arrRole = $dbrole->getAll();
            $dbcountry = new Country;
            $arrCountry = $dbcountry->getAll();
            $dbstate = new States;
            $arrState = $dbstate->getAll();
            $dbcity = new City;
            $arrCity = $dbcity->getAll();
            $data = $this->objModel->getOne($id);
            if (isset($data) && !empty($data)) {
                $messages = [
                    'name.required' => 'Please specify User Name',
                    'name.unique' => 'User Name already exists',
                    'name.regex' => 'User Name cannot have character other than a-z AND A-Z',
                ];

                $regxvalidator = [
                    'name' => 'required | regex:/^[a-zA-Z ]*$/ | unique:users,name,' . $request->id . ',id,deleted,0',
                ];
                $arrFile = array('name' => 'profile_photo', 'type' => 'image', 'resize' => '50', 'path' => 'admin/assets/media/users/', 'predefine' => '', 'except' => 'file_exist');
                if ($request->isMethod('post') && isset($id) && !empty($id)) {
                    // echo '<pre>'; print_r($request->all()); echo '</pre>'; die();
                    Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
                    return redirect('admin/myprofile/' . $id . '')->with(FLASH_MESSAGE_SUCCESS, Lang::get('common_message.update', [MODULE_NAME => ucwords(str_replace("-", " ", MODELNAME))]));
                    // return redirect('admin/myprofile/'.$id.'');
                }
                return view(RENDER_URL . '.profile', compact('data', 'arrCountry', 'arrRole', 'arrFile', 'arrCity', 'arrState'));
            } else {
                return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
            }
        }
    }

    public function changepassword(Request $request, $id = null)
    {
        if ($id == Session::get('id')) {
            $data = $this->objModel->getOne($id);

            if (isset($data) && !empty($data)) {
                if ($request->isMethod('post') && isset($id) && !empty($id)) {
                    $messages = [
                        'current_password.required' => 'Please enter Current Password',
                        'password.required' => 'Please enter New Password',
                        'password_confirmation.required' => 'Please Confirm New Password',
                    ];
                    $validator = Validator::make($request->all(), [
                        'current_password' => 'required',
                        'password' => 'required',
                        'password' => 'required |same:password_confirmation',
                        'password_confirmation' => 'required',
                    ], $messages);

                    if ($validator->fails()) {
                        $msg = $validator->errors()->all();
                        $msg = implode('<br>', $msg);
                        Session::flash('flash_error', $msg);
                    } else {
                        if (trim($request->current_password) != trim($request->password)) {
                            if (Hash::check(trim($request->current_password), trim($data->password))) {
                                $user_id = Auth::User()->id;
                                $obj_user = Users::find($user_id);
                                $obj_user->password = Hash::make(trim($request->password));
                                $obj_user->save();
                                Session::flash('flash_message_success', Lang::get('common_message.password_change', [MODULE_NAME => MODELNAME]));
                            } else {
                                Session::flash('flash_error', Lang::get('common_message.correct_current_pwd', [MODULE_NAME => MODELNAME]));
                            }
                        } else {
                            Session::flash('flash_error', Lang::get('common_message.correct_new_match', [MODULE_NAME => MODELNAME]));
                        }
                    }
                }
                return view(RENDER_URL . '.changepassword', compact('data'));
            } else {
                return redirect('admin/myprofile/' . Session::get('id'))->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
            }
        } else {
            return redirect('admin/myprofile/' . Session::get('id'))->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }

    public function getRights(Request $request)
    {
        $data = $request->input();
        $dbRoles = new Role;
        $roleId = $data['role_id'];
        $roleDetails = $dbRoles->getOne($roleId);
        $dbModules = new Users();
        $moduelsRights = $dbModules->getModules();
        $html = '<div class="card"><div class="card-body"><h4 class="card-title">Module Permission</h4><div class="card m-b-0 no-border"><div class="col-md-12"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="checkAll"><label class="custom-control-label" for="checkAll">Check / Uncheck Permission</label></div><div class="row row-eq-height">';
        if (isset($moduelsRights) && !empty($moduelsRights)) :
            $arrModules = array();
            foreach ($moduelsRights as $key => $val) :
                if ($key == 0) {
                    $preModules = $val->modulesName;
                } else {
                    $preModules = $moduelsRights[$key - 1]->modulesName;
                    if ($preModules != $val->modulesName) {
                        $html .= '</div></div></div></fieldset></div>';
                    }
                }
                if (!in_array($val->modulesName, $arrModules)) :
                    $modulesName = str_replace(' ', '_', $val->modulesName);
                    $html .= '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-container m10" id="heading-' . $key . '" ><div class="card-header col bdr-full"><fieldset class="group"> <legend><div class="custom-control custom-checkbox bdr"><input type="checkbox" class="checkAllByModule custom-control-input" id="' . $modulesName . '"><label class="custom-control-label header" for="' . $modulesName . '">' . $val->modulesName . '</label></div></legend>';
                endif;
                if (!in_array($val->modulesName, $arrModules)) :
                    /*if($key == 0):
						$html .= '<div id="collapse-'.$key.'" class="multi-collapse  collapse  show" style=""><div class="card-body widget-content">';
					else:*/
                    $html .= '<div id="' . $key . '" class="" style="padding-bottom:20px;"><div class="card-body widget-content">';
                    /*endif;*/
                    $arrModules[] = $val->modulesName;
                endif;
                $html .= '<div class="col-md-6" style="float:left"><div class="custom-control custom-checkbox">';
                $modulesName = str_replace(' ', '_', $val->modulesName);
                if (isset($data['id']) && !empty($data['id'])) {
                    $dbUsers = new User;
                    $id = $data['id'];
                    $userRoleDetails = $dbUsers->getOne($id);
                    if (isset($userRoleDetails->rights) && !empty($userRoleDetails->rights)) :
                        $existRights = explode(",", $userRoleDetails->rights);
                    else :
                        $existRights = explode(",", $roleDetails->rights);
                    endif;
                } else {
                    $existRights = explode(",", $roleDetails->rights);
                }
                if (in_array($val->rightsId, $existRights)) :
                    $html .= '<input type="checkbox" checked class="checkbox custom-control-input ' . $modulesName . '" id="rights-' . $key . '" name="rights[]" value="' . $val->rightsId . '">';
                else :
                    $html .= '<input type="checkbox" class="checkbox custom-control-input ' . $modulesName . '" id="rights-' . $key . '" name="rights[]" value="' . $val->rightsId . '">';
                endif;
                $html .= '<label class="custom-control-label" for="rights-' . $key . '">' . $val->rightsName . '</label></div></div>';
            endforeach;
        endif;
        $html .= '</div></div></div></div></div>';
        $arrResult['result'] = $html;
        echo json_encode($arrResult);
        die;
    }

    public function getStates(Request $request)
    {
        $dbStates  = new States;
        $state = $dbStates->getStateByCountryId($request->countryId);
        return response()->json($state);
    }

    public function getCities(Request $request)
    {
        $dbCities  = new City;
        $cities = $dbCities->getCityByStateId($request->stateID);
        return response()->json($cities);
    }

    public function checkAvailability(Request $request)
    {
        $dbUser = new User;
        $userDetails = $dbUser->getUserbyEmail($request->username, $request->id);

        echo json_encode(array('message' => '', 'data' => $userDetails, 'status' => ''));
        die;
    }

    public function deleteFile(Request $request)
    {
        $deleted = Common::commanDeleteFile($request->tableName, $request->id, $request->path, $request->file);

        echo json_encode(array('message' => '', 'data' => $deleted, 'status' => ''));
        die;
    }
}
