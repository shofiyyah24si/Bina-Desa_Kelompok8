<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;

class PoskoBencana extends Model
{
    use HasMedia;

    protected $table = 'posko_bencana';
    protected $primaryKey = 'posko_id';

    protected $fillable = [
        'kejadian_id',
        'nama',
        'alamat',
        'kontak',
        'penanggung_jawab',
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id');
    }
}
