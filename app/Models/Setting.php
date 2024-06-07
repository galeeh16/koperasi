<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property float $persen_anggota
 * @property float $persen_non_anggota
 * @property float $pph
 * @property float $ppn
 * @property string|DateTime created_at
 * @property ?string|?DateTime updated_at
 */
class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];

    public $timestamps = false;
    public $incrementing = true;
}
