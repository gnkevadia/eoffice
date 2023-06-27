<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class User_Comments extends Model
{
    use HasFactory;
    protected $table = 'user_comments';

    public function getAll()
    {
    }
    public function addComment($data)
    {
        $data->merge(['updated_by' => Session::get('id')]);
        $data->merge(['created_by' => Session::get('id')]);
        // if (Session::get('user')) {
        // }
        return User_Comments::insert($data->all());
    }
    public function user_comment()
    {
        return $this->hasMany('App\Models\Users', 'id', 'user_id');
    }
}
