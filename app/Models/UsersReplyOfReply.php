<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UsersReplyOfReply extends Model
{
    use HasFactory;
    protected $table = 'users_reply_of_reply';

    public function addReply($data)
    {
        $data->merge(['updated_by' => Session::get('id')]);
        $data->merge(['created_by' => Session::get('id')]);
        // if (Session::get('user')) {
        // }

        return UsersReplyOfReply::insert($data->all());
    }
    public function replyUser()
    {
        return $this->hasMany('App\Models\Users', 'id', 'user_id');
    }
}
