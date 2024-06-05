<?php

namespace App\Models;

use App\Models\DataKas;
use App\Models\JenisAkun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string kode_transaksi
 * @property string|DateTime tanggal_transaksi
 * @property int jumlah
 * @property string keterangan
 * @property int akun_id
 * @property int kas_id
 * @property int user_id
 * @property string|DateTime created_at
 * @property ?string|?DateTime updated_at
 */
class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];
    public $incrementing = true;
    public $timestamps = true;

    public function akun(): HasOne
    {
        return $this->hasOne(JenisAkun::class, 'id', 'akun_id');
    }

    public function kas(): HasOne
    {
        return $this->hasOne(DataKas::class, 'id', 'kas_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
