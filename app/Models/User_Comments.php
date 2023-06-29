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
    // public function user_comment()
    // {
    //     return $this->hasMany('App\Models\Users', 'id', 'user_id');
    // }

    // public function user_comment_reply()
    // {
    //     return $this->hasMany('App\Models\UsersCommentReply', 'comment_id', 'id');
    // }
    // public function user_comment_reply()
    // {
    //     return $this->hasMany('App\Models\Task', 'assigne', 'user_id');
    // }
    public function parent()
    {
        return $this->belongsTo('App\Models\User_Comments', 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\User_Comments', 'parent_id', 'id')->orderBy('id', 'ASC');
    }
    public function usersofComments()
    {
        return $this->hasMany('App\Models\Users', 'id', 'user_id');
    }
    public function getData($id)
    {
        // $comments = User_Comments::with('replies.usersofComments')->join('users', 'users.id', '=', 'user_comments.user_id')->orderBy('user_comments.id', 'ASC')->select('user_comments.*', 'users.name as userName', 'users.profile_photo as profile')->get();
        $comments = User_Comments::where(['ticket' => 'SD-2023', 'user_id' => '2252'])->get();
        echo '<pre>';
        echo ($comments);
        echo '</pre>';
        die();
        /* $comments = $this->display_comments('2252');
        echo '<pre>';
        print_r($comments);
        echo '</pre>';
        die(); */

        return $comments;
    }
    /*   public function fetch_article_comments($ticket, $parent)
    {
        $comments = User_Comments::where(['user_id' => $ticket])->get();
        return $comments;
    }
    public function display_comments($article_id, $parent_id = 0, $level = 0)
    {
        $comments = $this->fetch_article_comments($article_id, $parent_id);

        foreach ($comments as $comment) {
            echo '<pre>';
            echo ($comment);
            echo '</pre>';
            // die();
            $comment_id = $comment['id'];
            $member_id = $comment['member_id'];
            $comment_text = $comment['comment_text'];
            // $comment_timestamp = timeAgo($comment['comment_timestamp']);  //get time ago

            //render comment using above variables
            //Use $level to render the intendation level

            //Recurse
            $this->display_comments($article_id, $comment_id, $level + 1);
        }
    } */
}
