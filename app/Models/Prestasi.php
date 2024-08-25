<?php

namespace App\Models;

use App\Models\Ketua;
use App\Models\Pembina;
use App\Models\Ekstrakurikuler;
use App\Models\DaftarAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = ['ekstrakurikuler_id', 'ketua_id', 'pembina_id', 'prestasi', 'nama_siswa', 'kelas', 'tahun_ajaran', 'berkas', 'keterangan', 'status'];

    protected $casts = [
        'nama_siswa' => 'array', // Menyimpan nama siswa sebagai array
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

    public function ketua()
    {
        return $this->belongsTo(Ketua::class, 'ketua_id', 'id_ketua');
    }

    public function pembina()
    {
        return $this->belongsTo(Pembina::class, 'pembina_id', 'id_pembina');
    }

    public function daftarAnggota()
    {
        return $this->hasMany(DaftarAnggota::class, 'ekstrakurikuler_id', 'ekstrakurikuler_id');
    }
}
