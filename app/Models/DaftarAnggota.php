<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarAnggota extends Model
{
    use HasFactory;

    protected $table = 'daftar_anggota';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ekstrakurikuler_id',
        'nis',
        'nama',
        'kelas',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

}
