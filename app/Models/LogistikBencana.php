<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogistikBencana extends Model
{
    protected $table = 'logistik_bencana';
    protected $primaryKey = 'logistik_id';

    protected $fillable = [
        'kejadian_id',
        'nama_barang',
        'satuan',
        'stok',
        'sumber',
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id', 'kejadian_id');
    }
}
