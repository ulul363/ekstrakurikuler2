<?php

namespace App\Models;

use App\Models\Ketua;
use App\Models\Pembina;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class PengajuanPertemuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pertemuan';
    protected $primaryKey = 'id_pengajuan_pertemuan';

    protected $fillable = [
        'ketua_id',
        'pembina_id',
        'verifikasi_id',
        'hari',
        'tanggal',
        'waktu',
        'waktu_verifikasi',
        'status',
        'keterangan'
    ];

    // Tambahkan jika 'tanggal' dan 'waktu' perlu di-cast ke tipe tertentu
    protected $casts = [
        'tanggal' => 'date:Y-m-d', // Ganti format jika perlu
        'waktu' => 'datetime:H:i', // Ganti format jika perlu
        'waktu_verifikasi' => 'datetime:H:i', // Pastikan format yang sesuai
    ];

    public function getWaktuVerifikasiAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
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
