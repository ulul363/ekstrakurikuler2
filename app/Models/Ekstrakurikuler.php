<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler';
    protected $primaryKey = 'id_ekstrakurikuler';
    public $incrementing = true;

    protected $fillable = ['nama', 'deskripsi'];

    // Relasi dengan Ketua
    public function ketua()
    {
        return $this->belongsTo(Ketua::class, 'id_ekstrakurikuler', 'ekstrakurikuler_id');
    }

    // Relasi dengan Kehadiran
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

    // Relasi dengan ProgramKegiatan
    public function programKegiatan()
    {
        return $this->hasMany(ProgramKegiatan::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

    // Relasi dengan Pembina (Banyak ke Banyak)
    public function pembina()
    {
        return $this->hasMany(Pembina::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');

    }

    // Relasi dengan DaftarAnggota
    public function daftaranggota()
    {
        return $this->hasOne(DaftarAnggota::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }
}
