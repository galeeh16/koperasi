<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;
}
