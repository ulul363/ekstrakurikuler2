<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler';
    protected $primaryKey = 'id_ekstrakurikuler';

    protected $fillable = ['nama', 'deskripsi'];

    public function ketua()
    {
        return $this->hasOne(Ketua::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

    public function pembina()
    {
        return $this->hasMany(
            Pembina::class,
            'ekstrakurikuler_id',
            'id_ekstrakurikuler'
        );
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'ekstrakurikuler_id');
    }

    public function programKegiatan()
    {
        return $this->hasMany(ProgramKegiatan::class, 'ekstrakurikuler_id');
    }

    public function daftarAnggota()
    {
        return $this->hasMany(DaftarAnggota::class, 'ekstrakurikuler_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'ekstrakurikuler_id');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalEkstrakurikuler::class, 'ekstrakurikuler_id');
    }

    public function penilaian()
    {
        return $this->hasOne(
            PenilaianEkstrakurikuler::class,
            'ekstrakurikuler_id',
            'id_ekstrakurikuler'
        );
    }

    public function pengajuanPertemuan()
    {
        return $this->hasMany(PengajuanPertemuan::class, 'ekstrakurikuler_id');
    }

    public function getNamaEkstrakurikulerAttribute()
    {
        return $this->nama;
    }
}