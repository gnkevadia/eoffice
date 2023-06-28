<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\Task_image;
use Illuminate\Support\Facades\File;
use Monolog\Handler\ElasticaHandler;
use Illuminate\Support\Facades\Session;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task_master';

    public function getOne($id)
    {
        return Task::with('task_images')->where(['id' => $id])->first();
    }

    public function updateOne($id, $request)
    {

        $task_imges = $this->getOne($id);
        foreach ($task_imges->task_images as $image) {
            if (array_key_exists("remainimg", $request)) {
                $images = $request['remainimg'];
                if (!is_null($images)) {
                    if (!in_array($image->id, $images)) {
                        if (File::exists(public_path('images/task/' . $image->images))) {
                            File::delete(public_path('images/task/' . $image->images));
                        }
                        $taskimage = Task_image::where('id', $image->id)->delete();
                    }
                }
            } else {
                if (File::exists(public_path('images/task/' . $image->images))) {
                    File::delete(public_path('images/task/' . $image->images));
                }
                $taskimage = Task_image::where('id', $image->id)->delete();
            }
        }
        $task = Task::where(['id' => $id])->first();
        $task->project = $request['Project'];
        $task->features = $request['features'];
        $task->task = $request['task'];
        $task->description = $request['description'];
        $task->priority = $request['priority'];
        $task->assignee = $request['assignee'];
        $task->hour_task = $request['hour_task'];
        $task->start_date = $request['start_date'];
        $task->end_date = $request['end_date'];
        $task->cycle = $request['cycle'];
        $task->ticket = $request['ticket'];
        $task->status = $request['status'];
        $task->created_by = session()->get('id');
        $task->updated_by = session()->get('id');
        if (Session::get('superAdmin')) {
            $task->company_id = $request['company_id'];
            $task->department_id = $request['department_id'];
            $task->manager = $request['manager'];
        }
        if (Session::get('sub_admin')) {
            $task->company_id =  Session::get('company_id');
            $task->department_id = $request['department_id'];
            $task->manager = $request['manager'];
        }
        if (Session::get('manager')) {
            $task->company_id =  Session::get('company_id');
            $task->department_id = Session::get('department_id');
            $task->manager = Session::get('id');
        }
        if (Session::get('user')) {
            $task->company_id =  Session::get('company_id');
            $task->department_id = Session::get('department_id');
            $task->manager = Session::get('id');
        }
        $task->save();
        $insertId = $task->id;
        if (array_key_exists("file", $request)) {
            $files = $request['file'];
            foreach ($files as $file) {
                $image = $file;
                $extension = $image->getClientOriginalExtension();
                $img_name  =   rand() . time() . '.' . $extension;
                $file->move(public_path($request['path']), $img_name);
                $image = new Task_image();
                $image->task_id    = $insertId;
                $image->images = $img_name;
                $image->save();
            }
        }
        return true;
    }
    public function getAll($orderby = null, $where = array(), $dynamicWhere = '')
    {
        if (Session::get('superAdmin')) {
            $where = ['task_master.deleted' => 0];
        } else {
            $role_id = Session::get('settings');
            $where = ['task_master.deleted' => 0, 'task_master.company_id' => Session::get('company_id')];
        }
        $data =  Task::join('task_status', 'task_master.status', '=', 'task_status.id')->join('users', 'task_master.assignee', '=', 'users.id')->join('features_master', 'task_master.features', '=', 'features_master.id')->join('projectmaster', 'task_master.project', '=', 'projectmaster.id')->where($where)->select('task_master.*', 'features_master.name as features', 'projectmaster.name as project', 'users.name as assignee', 'users.id as assigneeId', 'task_status.name as status')->get();
        return $data;
    }
    public function deleteOne($id, $arrUpdate)
    {
        return Task::where('id', $id)->update($arrUpdate);
    }
    public function deleteAll($ids, $arrUpdate)
    {
        return Task::whereIn('id', explode(',', $ids))->update($arrUpdate);
    }
    public function bulkUpdate($ids, $arrUpdate)
    {
        $allids = ltrim($ids, 'on,');
        return Task::whereIn('id', explode(',', $allids))->update($arrUpdate);
    }

    public function task_images()
    {
        return $this->hasMany('App\Models\Task_image', 'task_id', 'id');
    }
    public function task_comments()
    {
        return $this->hasMany('App\Models\User_Comments', 'ticket', 'ticket');
    }
    public function reply_comments()
    {
        return $this->hasMany('App\Models\UsersCommentReply', 'ticket', 'ticket');
    }
    public function reply_of_reply()
    {
        return $this->hasMany('App\Models\UsersReplyOfReply', 'ticket', 'ticket');
    }
    public function getUserTasks($where)
    {
        $id = ['task_master.id' => $where];
        $query = Task::query();
        $data = $query->with('task_images', 'task_comments.user_comment', 'reply_comments.userOfReply', 'reply_of_reply.replyUser')->join('projectmaster', 'projectmaster.id', '=', 'task_master.project')->join('features_master', 'features_master.id', '=', 'task_master.features')->join('users', 'users.id', '=', 'task_master.manager')->join('priority', 'priority.id', '=', 'task_master.priority')->where($id)->select('task_master.*', 'projectmaster.name as projectName', 'features_master.name as featuresss', 'users.name as managerName', 'priority.priority as priorityName')->first();
        // echo '<pre>';
        // echo ($data);
        // echo '</pre>';
        // die();
        // foreach ($data->reply_comments as $dataone) {

        //     echo '<pre>';
        //     echo ($dataone->userOfReply);
        //     echo '</pre>';
        // }
        // die();

        return $data;
    }
    public function statusUpdate($id, $arrUpdate)
    {
        return Task::where('id', $id)->update($arrUpdate);
    }
}
