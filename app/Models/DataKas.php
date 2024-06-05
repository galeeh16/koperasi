<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKas extends Model
{
    protected $table = 'data_kas';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
}
