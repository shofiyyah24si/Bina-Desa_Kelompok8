<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;

class DistribusiLogistik extends Model
{
    use HasMedia;

    protected $table = 'distribusi_logistik';
    protected $primaryKey = 'distribusi_id';

    protected $fillable = [
        'logistik_id',
        'posko_id',
        'tanggal',
        'jumlah',
        'penerima',
    ];

    public function logistik()
    {
        return $this->belongsTo(LogistikBencana::class, 'logistik_id');
    }

    public function posko()
    {
        return $this->belongsTo(PoskoBencana::class, 'posko_id');
    }
}
