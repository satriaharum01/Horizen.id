<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal','id_barang','id_supplier','qty'];

    public function cari_barang()
    {
        return $this->belongsTo('App\Models\Barang', 'id_barang', 'id')->withDefault([
            'nama' => 'Null'
        ]);
    }

    public function cari_supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'id_supplier', 'id')->withDefault([
            'nama' => 'Null'
        ]);
    }
}
