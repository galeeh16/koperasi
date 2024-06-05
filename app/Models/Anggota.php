<?php

namespace App\Models;

use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Departemen;
use App\Models\StatusMenikah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;

    // anggota attribute
    // public function photo(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(?string $value) => $value ? Storage::url($value) : null
    //     );
    // }

    public function statusMenikah(): HasOne
    {
        return $this->hasOne(StatusMenikah::class, 'id', 'status_menikah');
    }

    public function departemen(): HasOne
    {
        return $this->hasOne(Departemen::class, 'id', 'departemen');
    }

    public function pekerjaan(): HasOne
    {
        return $this->hasOne(Pekerjaan::class, 'id', 'pekerjaan');
    }

    public function agama(): HasOne
    {
        return $this->hasOne(Agama::class, 'id', 'agama');
    }
}

