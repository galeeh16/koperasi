<?php

namespace App\Models;

use App\Models\DataKas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string kode_transaksi
 * @property string|DateTime tanggal_transaksi
 * @property int jumlah
 * @property string keterangan
 * @property int dari_kas_id
 * @property int untuk_kas_id
 * @property int user_id
 * @property string|DateTime created_at
 * @property ?string|?DateTime updated_at
 */
class Transfer extends Model
{
    protected $table = 'transfer';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];
    public $incrementing = true;
    public $timestamps = true;

    public function dariKas(): HasOne
    {
        return $this->hasOne(DataKas::class, 'id', 'dari_kas_id');
    }

    public function untukKas(): HasOne
    {
        return $this->hasOne(DataKas::class, 'id', 'untuk_kas_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
