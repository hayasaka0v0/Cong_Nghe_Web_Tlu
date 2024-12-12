<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = ['id','first_name','last_name','date_of_birth','parent_phone','class_id'];
}
