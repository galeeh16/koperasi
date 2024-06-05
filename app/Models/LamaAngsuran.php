<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LamaAngsuran extends Model
{
    protected $table = 'lama_angsuran';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
}
