<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Medicines extends Model
{
    use HasFactory;
    protected $table = 'computers';
    protected $primarykey = 'id';
    public function sales()
    {
        return $this->hasMany(Sales::class, 'medicine_id', 'id');
    }
}
