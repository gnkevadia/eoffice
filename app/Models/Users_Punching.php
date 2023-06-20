<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_Punching extends Model
{
    use HasFactory;
    protected $table = 'users_punching';

    public function updateOne($id, $arrUpdate)
    {
        // echo '<pre>'; print_r($id); echo '</pre>'; die();
        // echo '<pre>'; print_r(Users_Punching::where('user_id', $id)->get()); echo '</pre>'; die();
        return Users_Punching::where('user_id', $id)->update($arrUpdate);
    }
}
