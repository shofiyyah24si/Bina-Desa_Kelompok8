<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;

class DonasiBencana extends Model
{
    use HasMedia;

    protected $table = 'donasi_bencana';
    protected $primaryKey = 'donasi_id';

    protected $fillable = [
        'kejadian_id',
        'donatur_nama',
        'jenis',
        'nilai',
        'keterangan_barang',
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id');
    }
}
