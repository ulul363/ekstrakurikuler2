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
        'status',
        'keterangan',
    ];

    /**
     * Get the ekstrakurikuler associated with the kehadiran.
     */
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

    /**
     * Get the ketua associated with the kehadiran.
     */
    public function ketua()
    {
        return $this->belongsTo(Ketua::class, 'ketua_id', 'id_ketua');
    }

    /**
     * Get the pembina (verifikasi) associated with the kehadiran.
     */
    public function pembina()
    {
        return $this->belongsTo(Pembina::class, 'pembina_id', 'id_pembina');
    }
}
