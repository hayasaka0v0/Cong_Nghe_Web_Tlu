<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PHPUnit\Runner\Baseline\Issue;

class Computers extends Model
{
    use HasFactory;
    protected $table = 'computers';
    protected $primarykey = 'id';
    public function issues()
    {
        return $this->hasMany(Issues::class, 'computer_id', 'id');
    }
}
