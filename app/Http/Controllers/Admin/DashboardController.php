<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Package;
use App\Models\Users;
use App\Models\Users_Punching;
use App\Models\Task;
use App\Models\ProjectMaster;
use App\Library\Common;
use App\Models\Company;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;




class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (session()->get('superAdmin')) {
            $where = ['task_master.deleted' => 0];
            $where_done_task = ['task_master.deleted' => 0, 'task_master.status' => 14];
            $where_project = ['projectmaster.deleted' => 0];
            $where_company = ['company.deleted' => 0];
            $where_status = ['users_punching.user_id' => session()->get('id')];
        } else {
            $role_id = session()->get('settings');
            $where = ['task_master.deleted' => 0, 'task_master.company_id' => session()->get('company_id')];
            $where_done_task = ['task_master.deleted' => 0, 'task_master.company_id' => session()->get('company_id'), 'task_master.status' => 14];
            $where_project = ['projectmaster.deleted' => 0, 'projectmaster.company_id' => session()->get('company_id')];
            $where_status = ['users_punching.user_id' => session()->get('id')];
        }
        $user_punching = Users_Punching::join('users', 'users.id', '=', 'users_punching.user_id')->select('users_punching.*','users.name')->where($where_status)->latest()->take(7)->get();
        // echo '<pre>'; echo($user_punching); echo '</pre>'; die();
        $total_time = 0;
        $count_data = 1;
        foreach ($user_punching as $key => $punch) {
            if (!empty($punch->punch_in) && !empty($punch->punch_out)) {
                $punchin = $punch->punch_in;
                $punchin_tiem = Carbon::createFromFormat("Y-m-d H:i:s", $punchin);
                $punchout[$key] = $punch->punch_out;
                $punchouttime = $punch->punch_out;
                $punchout_tiem = Carbon::createFromFormat("Y-m-d H:i:s", $punchouttime);
                $diff_in_hours = $punchin_tiem->diff($punchout_tiem)->format('%H:%I:%S');
                $count_data = count($punchout);
                $total_time = $total_time+strtotime($diff_in_hours);
                $user_punching[$key]['diff']= $diff_in_hours;
            }
        }
        $averge = $total_time / $count_data;
        $averge_time = date("H:i:s",$averge);
        $today_project =  ProjectMaster::join('users', 'users.id', '=', 'projectmaster.manager')->where($where_project)->select('projectmaster.*', 'users.name as manager')->whereDay('projectmaster.created_at', Carbon::today())->latest()->get();
        $task = Task::join('priority', 'task_master.priority', '=', 'priority.id')->join('users', 'task_master.assignee', '=', 'users.id')->where($where)->orderBy('task_master.priority', 'asc')->latest('task_master.created_at')->get();
        $done_task = Task::join('priority', 'task_master.priority', '=', 'priority.id')->join('users', 'task_master.assignee', '=', 'users.id')->where($where_done_task)->orderBy('task_master.priority', 'asc')->latest('task_master.created_at')->get();
        $task_all = Task::join('priority', 'task_master.priority', '=', 'priority.id')->where($where)->get();
        $projrct = ProjectMaster::where($where_project)->get();
        if (session()->get('superAdmin')) {
            $company = Company::where($where_company)->get();

            return view('admin.user.dashboard', compact('task', 'task_all', 'projrct', 'company', 'today_project', 'done_task', 'user_punching',));
        }
        if (isset($diff_in_hours)) {
            return view('admin.user.dashboard', compact('task', 'task_all', 'projrct', 'today_project', 'done_task', 'user_punching', 'diff_in_hours','averge_time'));
        }
        return view('admin.user.dashboard', compact('task', 'task_all', 'projrct', 'today_project', 'done_task', 'user_punching','averge_time'));
    }
    public function punchin()
    {
        $getUser = new Users_Punching();
        $punch_in  = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        $getUser->user_id =  session()->get('id');
        $getUser->punch_in =  $punch_in;
        $punch_in = date('g:i A j F, Y', strtotime($punch_in));
        $getUser->save();
        session()->put('punchin', true);
        session()->put('punchIn_time', $punch_in);

        return  $punch_in;
    }
    public function punchout()
    {
        $getUser = new Users_Punching();
        $punch_out  = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        $punchout = array('user_id' => session()->get('id'), 'punch_out' => $punch_out);
        $punch_out = date('g:i A j F, Y', strtotime($punch_out));
        $id = session()->get('id');
        $time = $getUser->updateOne($id, $punchout);
        session()->put('punchin', false);
        session()->put('punchOut_time', $punch_out);
        session()->put('punchout', true);
        return  $punch_out;
    }
}
