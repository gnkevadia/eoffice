<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UsersCommentReply extends Model
{
    use HasFactory;
    protected $table = 'users_comment_reply';
    public function addReplyComment($data)
    {
        $data->merge(['updated_by' => Session::get('id')]);
        $data->merge(['created_by' => Session::get('id')]);
        // if (Session::get('user')) {
        // }

        return UsersCommentReply::insert($data->all());
    }
    public function user_reply()
    {
        return $this->hasMany('App\Models\Task', 'ticket', 'ticket');
    }
    public function userOfReply()
    {
        return $this->hasMany('App\Models\Users', 'id', 'user_id');
    }
}
