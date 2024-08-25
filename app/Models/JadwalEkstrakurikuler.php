<?php

namespace App\Models;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalEkstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ekstrakurikuler';
    protected $primaryKey = 'id_jadwal_ekstrakurikuler';

    protected $fillable = [
        'ekstrakurikuler_id',
        'hari',
        'waktu',
        'lokasi'
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }
}