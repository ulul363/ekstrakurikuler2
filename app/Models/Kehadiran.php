<?php

namespace App\Models;

use App\Models\Ketua;
use App\Models\Pembina;
use App\Models\Ekstrakurikuler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran';

    protected $fillable = [
        'ekstrakurikuler_id',
        'ketua_id',
        'pembina_id',
        'nama_kegiatan',
        'tahun_ajaran',
        'tanggal',
        'deskripsi',
        'berkas',
        'jumlah_hadir',
        'jumlah_anggota',
        'status',
        'keterangan_pembina',
    ];

    // 🔥 SPK: persentase kehadiran (INI PENTING UNTUK MARCOS)
    public function getPersentaseKehadiranAttribute()
    {
        if (!$this->jumlah_anggota || $this->jumlah_anggota == 0) {
            return 0;
        }

        return ($this->jumlah_hadir / $this->jumlah_anggota) * 100;
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(
            Ekstrakurikuler::class,
            'ekstrakurikuler_id',
            'id_ekstrakurikuler'
        );
    }

    public function ketua()
    {
        return $this->belongsTo(
            Ketua::class,
            'ketua_id',
            'id_ketua'
        );
    }

    public function pembina()
    {
        return $this->belongsTo(
            Pembina::class,
            'pembina_id',
            'id_pembina'
        );
    }
}