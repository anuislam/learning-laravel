<?php

namespace Modules\Gymwebsite\Entities;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['email', 'mobile', 'message', 'program_titile', 'created_at', 'updated_at'];
}
