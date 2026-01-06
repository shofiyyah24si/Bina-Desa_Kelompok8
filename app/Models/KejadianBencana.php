<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KejadianBencana extends Model
{
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

    /**
     * Relasi ke media (multiple photos)
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'kejadian_id')
            ->where('ref_table', 'kejadian_bencana')
            ->orderBy('sort_order');
    }

    /**
     * Check if kejadian has photos
     */
    public function hasPhotos()
    {
        return $this->media()->count() > 0;
    }

    /**
     * Get first photo URL for thumbnail
     */
    public function getFirstPhotoUrl()
    {
        $firstMedia = $this->media()->first();
        if ($firstMedia) {
            return asset('uploads/' . $firstMedia->file_url);
        }
        return asset('assets-admin/images/default-disaster.png');
    }
}
