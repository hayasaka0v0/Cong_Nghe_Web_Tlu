<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Computer extends Model
{
    use HasFactory;
    protected $fillable = ['computer_name', 'operating_system', 'processor', 'memory', 'available'];

    
    
}
