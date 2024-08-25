<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nis'; 
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'alamat',
        'jenis_kelamin',
        'email',
        'no_hp'
    ];
}
