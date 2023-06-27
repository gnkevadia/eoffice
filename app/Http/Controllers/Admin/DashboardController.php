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
use Session;




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
            $where_project = ['projectmaster.deleted' => 0];
            $where_company = ['company.deleted' => 0];
        } else {
            $role_id = session()->get('settings');
            $where = ['task_master.deleted' => 0, 'task_master.company_id' => session()->get('company_id')];
            $where_project = ['projectmaster.deleted' => 0, 'projectmaster.company_id' => session()->get('company_id')];
        }
        $today_project =  ProjectMaster::join('users', 'users.id', '=', 'projectmaster.manager')->where($where_project)->select('projectmaster.*', 'users.name as manager')->whereDay('projectmaster.created_at', Carbon::today())->latest()->get();
        $task = Task::join('priority', 'task_master.priority', '=', 'priority.id')->join('users', 'task_master.assignee', '=', 'users.id')->where($where)->latest('task_master.created_at')->orderBy('task_master.priority', 'asc')->get();
        $task_all = Task::join('priority', 'task_master.priority', '=', 'priority.id')->where($where)->get();
        $projrct = ProjectMaster::where($where_project)->get();
        if (session()->get('superAdmin')) {
            $company = Company::where($where_company)->get();

            return view('admin.user.dashboard', compact('task', 'task_all', 'projrct', 'company','today_project'));
        }
        return view('admin.user.dashboard', compact('task', 'task_all', 'projrct','today_project'));
    }
    public function punchin()
    {
        $getUser = new Users_Punching();
        $punch_in  = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        $getUser->user_id =  session()->get('id');
        $getUser->punch_in =  $punch_in;
        // $punchin = array('punch_in' => $pinch_in, 'user_id' => session()->get('id'));
        $punch_in = date('g:i A j F, Y', strtotime($punch_in));
        // $id = session()->get('id');
        // $time = $getUser->updateOne($id, $punchin);
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
        // $getUser->save();
        return  $punch_out;
    }
}
