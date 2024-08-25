<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EkstrakurikulerPembina extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler_pembina';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'ekstrakurikuler_id',
        'id_pembina',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }

    public function pembina()
    {
        return $this->belongsTo(Pembina::class, 'pembina_id', 'id_pembina');
    }
}
