<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    protected $fillable = ['kode','tanggal','id_user'];

    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id')->withDefault([
            'name' => 'Guest',
            'email' => 'Guest',
            'no_hp' => '0',
            'level' => '0'
        ]);
    }
}
