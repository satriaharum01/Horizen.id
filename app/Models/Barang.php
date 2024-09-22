<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = ['nama','harga','id_kategori'];

    public function cari_kategori()
    {
        return $this->belongsTo('App\Models\Kategori', 'id_kategori', 'id')->withDefault([
            'nama' => 'Belum di set'
        ]);
    }
}
