<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';

    protected $fillable = [
        'id_user',
        'id_barang',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_reservasi',
        'status_pinjam',
    ];

    public function users(){
        return $this->belongsTo('App\Models\User');
    }

    public function barang(){
        return $this->belongsTo('App\Models\Barang');
    }
}