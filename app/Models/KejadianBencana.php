<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;

class KejadianBencana extends Model
{
    use HasMedia;

    protected $table = 'kejadian_bencana';
    protected $primaryKey = 'kejadian_id';

    protected $fillable = [
        'jenis_bencana',
        'tanggal',
        'lokasi_text',
        'rt',
        'rw',
        'dampak',
        'status_kejadian',
        'keterangan',
    ];
}
