<?php

namespace App\Models;

use App\Models\Ketua;
use App\Models\Pembina;
use App\Models\Ekstrakurikuler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramKegiatan extends Model
{
    use HasFactory;

    protected $table = 'program_kegiatan';
    protected $primaryKey = 'id_program_kegiatan';

    protected $fillable = [
        'ekstrakurikuler_id',
        'ketua_id',
        'nama_program',
        'tahun_ajaran',
        'deskripsi',
        'pembina_id',
        'status',
        'keterangan',
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

}