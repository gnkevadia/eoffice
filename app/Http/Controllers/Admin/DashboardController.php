<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Package;
use App\Models\Users;
use App\Models\Task;
use App\Models\ProjectMaster;
use App\Library\Common;
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
        $task = Task::join('priority', 'task_master.priority', '=', 'priority.id')->where('task_master.deleted', 0)->paginate(4);
        $task_all = Task::join('priority', 'task_master.priority', '=', 'priority.id')->where('task_master.deleted', 0)->get();
        $projrct = ProjectMaster::where('deleted', 0)->get();
        
        return view('admin.user.dashboard', compact('task','task_all','projrct'));
    }
    public function punchin(){
        $pinch_in  = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        $punchin = array('punch_in' => $pinch_in);
        $pinch_in = date('g:i A j F, Y',strtotime($pinch_in));
        $getUser = new Users();
        $id = session()->get('id');
        $time = $getUser->updateOne($id, $punchin);
        session()->put('pinchin', true);
        session()->put('pinchin_time', $pinch_in);
        return  $pinch_in;  
    }
    public function punchout(){
        $punch_out  = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        $punchout = array('punch_out' => $punch_out);
        $punch_out = date('g:i A j F, Y',strtotime($punch_out));
        $getUser = new Users();
        $id = session()->get('id');
        $time = $getUser->updateOne($id, $punchout);
        session()->put('pinchin', false);
        session()->put('pinchout_time', $punch_out);
        session()->put('pinchout', true);
        return  $punch_out;  
    }
}
