<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusMenikah extends Model
{
    protected $table = 'status_menikah';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;
}
