<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string kode_aktiva
 * @property string jenis_transaksi
 * @property string akun
 * @property string pemasukan
 * @property string pengeluaran
 * @property string laba_rugi
 * @property string|DateTime created_at
 * @property ?string|?DateTime updated_at
 */
class JenisAkun extends Model
{
    protected $table = 'jenis_akun';
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
}
