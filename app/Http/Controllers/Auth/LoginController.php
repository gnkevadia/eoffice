<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
// use App\User;
use App\Models\Role;
use App\Models\Users_Punching;
use App\Models\Rights;
use App\Models\Setting;
use Redirect;
// use Session;
use Illuminate\Support\Facades\Session;
use Config;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Models\User;
use App\Library\Common;
use App\Models\City;

use App\Models\EmailTemplates;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showFormLogin()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        $Setting = new Setting();
        $credentials = [
            'email' => $request->username,
            'password' => trim($request->password)
        ];
        $userDetails = User::where('email', $request->username)->first();
        if (isset($userDetails) && !empty($userDetails)) {
            if (auth()->attempt($credentials)) {
                $Users_Punching = Users_Punching::where(['user_id' => $userDetails->id])->orderBy('updated_at', 'desc')->first();
                // echo '<pre>'; print_r($Users_Punching['punch_in']); echo '</pre>'; die();
                $arrSettings = $Setting->getSettingByName('ALLOWED_IP');
                $arrSettingscheck = $Setting->getSettingByName('ALLOWED_IP_ENABLE');


                if ($arrSettingscheck['value'] != '1' || ($arrSettingscheck['value'] == '1' && isset($arrSettings['name']) && !empty($arrSettings['name']) && in_array($request->ip(), explode(",", $arrSettings['value'])))) {
                    Session::put('email', $userDetails['email']);
                    Session::put('id', $userDetails->id);
                    Session::put('role', $userDetails->role_id);
                    Session::put('firstname', $userDetails->firstName);
                    Session::put('lastname', $userDetails->lastName);
                    Session::put('name', $userDetails->name);
                    Session::put('company_id', $userDetails->company_id);
                    Session::put('profile_photo', asset('admin/assets/media/users/50x50/' . $userDetails->profile_photo));
                    Common::getSettings();
                    if (!empty($Users_Punching && date('Y-m-d'))) {
                        Session::put('punchIn', true);
                        Session::put('punchout', false);
                        $punch_in = date('g:i A j F, Y', strtotime($Users_Punching['punch_in']));
                        Session::put('punchIn_time', $punch_in);
                    }

                    if (!empty($Users_Punching['punch_out'])) {
                        Session::put('punchout', true);
                        Session::put('punchIn', false);
                        $punch_out = date('g:i A j F, Y', strtotime($Users_Punching['punch_out']));
                        Session::put('punchOut_time', $punch_out);
                    }
                    $roleDetails = Role::where(['id' => $userDetails->role_id])->first();
                    Session::put('rights', explode(",", $roleDetails->rights));
                    $rightDetails = Rights::whereIn('id', explode(",", $roleDetails->rights))->get();
                    $arrRights = array();
                    foreach ($rightDetails as $keyRights => $valRights) {
                        $arrRights[$valRights->id] = $valRights->routes;
                    }
                    Session::put('routes', $arrRights);
                    if ($roleDetails->id == '1') {
                        Session::put('superAdmin', true);
                    }
                    return json_encode(array("status" => 1, "msg" => "Login Successful.", "action" => "/admin/dashboard", "data" => $userDetails));
                } else {
                    session()->flush();
                    return json_encode(array("status" => 0, "msg" => "Ip is not allowed.", "action" => "login", "data" => array()));
                }
            } else {
                return json_encode(array("status" => 0, "msg" => "Incorrect username or password. Please try again.", "action" => "login", "data" => array()));
            }
        } else {
            return json_encode(array("status" => 0, "msg" => "Incorrect username or password. Please try again.", "action" => "login", "data" => array()));
        }
    }
    public function checkAuthLevel(Request $request)
    {
        $Setting = new Setting;

        $credentials = [
            'email' => $request->username,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $userDetails = User::where('email', $request->username)->first();
            $arrSettings = $Setting->getSettingByName('ALLOWED_IP');
            $arrSettingscheck = $Setting->getSettingByName('ALLOWED_IP_ENABLE');
            $arrSettingsauth = $Setting->getSettingByName('TWO_LEVEL_AUTHENTICATION');

            if ($arrSettingscheck['value'] != '1' || ($arrSettingscheck['value'] == '1' && isset($arrSettings['name']) && !empty($arrSettings['name']) && in_array($request->ip(), explode(",", $arrSettings['value'])))) {
                if ($arrSettingsauth['value'] == 1) {

                    $subject = 'Send OTP';
                    $body = "Please use the following security code for the ATL account. Security code: 6875089";
                    $email = "test@gmail.com";

                    Mail::send([], [], function ($message) use ($email, $subject, $body) {
                        $message->to($email)
                            ->subject($subject)
                            ->setBody($body, 'text/html');
                    });

                    return '1';
                } else {
                    return '0';
                }
            } else {
                session()->flush();
                $errors = new MessageBag(['password' => ['Ip is not allowed']]);
                return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
            }
        } else {
            $errors = new MessageBag(['password' => ['Email or Password Invalid.']]);
            return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
        }
    }

    /**
     * Back End Forgot Password
     * Retrive forgot password, System will send automated email to recover user password.
     *
     * @author ATL
     * @since Jan 2020
     */
    public function forgotLogin(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            $userDetails = User::where('email', $data['email'])->first();
            $dbSettings = new Setting;
            $settings = $dbSettings->getAllSetting();
            if (isset($settings) && !empty($settings)) {
                $arrSettings = array();
                foreach ($settings as $keySettings => $valSettings) {
                    $arrSettings[$valSettings->name] = $valSettings->value;
                }
            }
            if (isset($userDetails) && !empty($userDetails) && !empty(array_intersect(explode(",", $userDetails->role_id), explode(",", $arrSettings['ALLOWED_ADMIN_LOGIN'])))) {
                $dbEmailTemplates = new EmailTemplates;
                $emialTemplates = $dbEmailTemplates->where(['deleted' => 0, 'slug' => 'forgot-password'])->first();
                $emailData = [
                    'siteURL' => url('/'),
                    'userName' => $userDetails->name,
                    'resetPasswordLink'  => base64_encode($userDetails->id)
                ];

                $parsed = $emialTemplates->parse($emailData);
                Mail::send([], [], function ($message) use ($emialTemplates, $userDetails, $arrSettings, $parsed) {
                    $message->to($userDetails->email)
                        ->subject($emialTemplates->name)
                        ->from($arrSettings['MAIL_FROM_EMAIL'], $arrSettings['MAIL_FROM_NAME'])
                        ->setBody($parsed, 'text/html');
                });
                return json_encode(array("status" => 1, "msg" => "Cool! Password recovery instruction has been sent to your email.", "action" => "", "data" => $userDetails));
            } else {
                return json_encode(array("status" => 0, "msg" => "Invalid email! This email doesn't exist with our database.", "action" => "", "data" => array()));
            }
        }
        return view('admin.auth.login', compact('data', 'userDetails'));
    }
    /**
     * Back End Set New Password
     * User will redirect if they requested for forgot password, Using this method user can set their new password
     *
     * @author ATL
     * @since Jan 2020
     */
    public function forgotPassword(Request $request, $id)
    {
        $id = base64_decode($id);
        if ($request->isMethod('post')) {
            $data = $request->input();
            $password = bcrypt($data['password']);
            User::where('id', $data['id'])->update(['password' => $password]);
            return json_encode(array("status" => 1, "msg" => "Password reset successfully", "action" => "/login", "data" => array()));
        }
        return view('admin.auth.forgot-login', compact('id'));
    }

    public function logout(Request $request)
    {
        if ($request->session()->get('admin') == true) {
            $redirectTo = '/admin/login';
        } else {
            $redirectTo = '/admin/login';
        }
        Auth::logout();
        session()->flush();
        return redirect($redirectTo);
    }
}
