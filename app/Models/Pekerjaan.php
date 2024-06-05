<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $table = 'pekerjaan';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;
}
