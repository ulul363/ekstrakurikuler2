<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPertemuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pertemuan';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'ekstrakurikuler_id',
        'ketua_id',
        'pembina_id',
        'judul_pertemuan',
        'tanggal_rencana',
        'waktu_rencana',
        'agenda_pertemuan',
        'status',
        'keterangan_pembina'
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