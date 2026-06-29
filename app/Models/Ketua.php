<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ketua extends Model
{
    use HasFactory;

    protected $table = 'ketua';
    protected $primaryKey = 'id_ketua';
    public $incrementing = true;

    protected $fillable = ['user_id', 'nis', 'nama', 'ekstrakurikuler_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

    public function programKegiatan()
    {
        return $this->hasMany(
            ProgramKegiatan::class,
            'ketua_id',
            'id_ketua'
        );
    }

    public function kehadiran()
    {
        return $this->hasMany(
            Kehadiran::class,
            'ketua_id',
            'id_ketua'
        );
    }

    public function prestasi()
    {
        return $this->hasMany(
            Prestasi::class,
            'ketua_id',
            'id_ketua'
        );
    }

    public function pengajuanPertemuan()
    {
        return $this->hasMany(PengajuanPertemuan::class, 'ketua_id', 'id_ketua');
    }
}
