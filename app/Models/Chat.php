<?php

namespace App\Models;

use App\Models\Ketua;
use App\Models\Pembina;
use App\Models\PengajuanPertemuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';
    protected $primaryKey = 'id_chat';

    protected $fillable = [
        'id_chat',
        'pengirim',
        'pesan',
        'pengajuan_pertemuan_id'
    ];

    public function pengajuanPertemuan()
    {
        return $this->belongsTo(PengajuanPertemuan::class, 'pengajuan_pertemuan_id', 'id_pengajuan_pertemuan');
    }
}
