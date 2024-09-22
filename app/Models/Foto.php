<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $table = 'foto';
    protected $primaryKey = 'id';
    protected $fillable = ['status','id_barang','file'];

    public function cari_barang()
    {
        return $this->belongsTo('App\Models\Barang', 'id_barang', 'id')->withDefault([
            'nama' => 'Belum di set'
        ]);
    }
}
