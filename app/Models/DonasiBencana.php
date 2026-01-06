<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonasiBencana extends Model
{
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

    /**
     * Relasi ke media dengan error handling
     */
    public function media()
    {
        try {
            return $this->hasMany(Media::class, 'ref_id', 'donasi_id')
                        ->where('ref_table', 'donasi_bencana')
                        ->orderBy('sort_order')
                        ->orderBy('media_id');
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Get media safely
     */
    public function getMediaSafely()
    {
        try {
            return $this->media;
        } catch (\Exception $e) {
            return collect([]);
        }
    }
}
