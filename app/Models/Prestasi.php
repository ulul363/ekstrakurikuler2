<?php

namespace App\Models;

use App\Models\Ketua;
use App\Models\Pembina;
use App\Models\Ekstrakurikuler;
// use App\Models\DaftarAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = [
        'ekstrakurikuler_id',
        'ketua_id',
        'pembina_id',
        'prestasi',
        'tingkat',
        'skor_prestasi',
        'nama_siswa',
        'tahun_ajaran',
        'berkas',
        'status',
    ];

    protected $casts = [
        'nama_siswa' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($prestasi) {
            $prestasi->skor_prestasi = match ($prestasi->tingkat) {
                'nasional' => 100,
                'provinsi' => 80,
                'kabupaten' => 60,
                'kecamatan' => 40,
                default => 20
            };
        });
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