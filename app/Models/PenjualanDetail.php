<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id';
    protected $fillable = ['id_penjualan','qty','harga','id_barang'];

    public function cari_penjualan()
    {
        return $this->belongsTo('App\Models\Penjualan', 'id_penjualan', 'id')->withDefault([
            'tanggal' => 'Null'
        ]);
    }

    public function cari_barang()
    {
        return $this->belongsTo('App\Models\Barang', 'id_barang', 'id')->withDefault([
            'nama' => 'Null'
        ]);
    }
}
