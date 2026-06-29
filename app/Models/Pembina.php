<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembina extends Model
{
    use HasFactory;

    protected $table = 'pembina';
    protected $primaryKey = 'id_pembina';
    public $incrementing = true;

    protected $fillable = ['user_id', 'nip', 'nama', 'ekstrakurikuler_id', 'status'];

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
            'pembina_id',
            'id_pembina'
        );
    }

    public function kehadiran()
    {
        return $this->hasMany(
            Kehadiran::class,
            'pembina_id',
            'id_pembina'
        );
    }

    public function prestasi()
    {
        return $this->hasMany(
            Prestasi::class,
            'pembina_id',
            'id_pembina'
        );
    }

    public function pengajuanPertemuan()
    {
        return $this->hasMany(PengajuanPertemuan::class, 'pembina_id', 'id_pembina');
    }
}
