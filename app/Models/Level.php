<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;
}
