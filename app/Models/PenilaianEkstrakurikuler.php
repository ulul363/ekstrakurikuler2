<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianEkstrakurikuler extends Model
{
    use HasFactory;
    protected $table = 'penilaian_ekstrakurikuler';

    protected $fillable = [
        'ekstrakurikuler_id',
        'c1_kehadiran',
        'c2_prestasi',
        'c3_program_kerja',
        'c4_intensitas',
        'nilai_akhir',
        'ranking',
    ];

    protected $casts = [
        'c1_kehadiran' => 'float',
        'c2_prestasi' => 'float',
        'c3_program_kerja' => 'float',
        'c4_intensitas' => 'float',
        'nilai_akhir' => 'float',
        'ranking' => 'integer',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(
            Ekstrakurikuler::class,
            'ekstrakurikuler_id',
            'id_ekstrakurikuler'
        );
    }
}