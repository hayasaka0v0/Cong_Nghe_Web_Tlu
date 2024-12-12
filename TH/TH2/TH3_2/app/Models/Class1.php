<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Class1 extends Model
{
    use HasFactory;
    protected $table = "classes";
    protected $fillable = ['id', 'grade_level', 'room_number'];
    protected $primarykey = 'id';
    public function students()
    {
        return $this->hasMany(Students::class, 'class_id', 'id');
    }
}
