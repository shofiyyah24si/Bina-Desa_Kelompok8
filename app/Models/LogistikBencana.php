<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogistikBencana extends Model
{
    protected $table = 'logistik_bencana';
    protected $primaryKey = 'logistik_id';

    protected $fillable = [
        'kejadian_id',
        'tanggal_masuk',
        'nama_barang',
        'satuan',
        'stok',
        'sumber',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id', 'kejadian_id');
    }
}
