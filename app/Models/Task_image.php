<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_image extends Model
{
    use HasFactory;
    protected $table = 'task_images';


    public function task(){
        return $this->hasMany('App\Models\Task', 'id', 'task_id');
    }


}
