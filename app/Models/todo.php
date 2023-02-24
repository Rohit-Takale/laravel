<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    use HasFactory;

    protected $table = 'todo';

    protected $dates = ['created_at'];

    protected $fillable = ['task_name','task_desc','status'];

}
