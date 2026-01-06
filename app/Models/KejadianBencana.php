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
     * Relasi ke media dengan error handling
     */
    public function media()
    {
        try {
            return $this->hasMany(Media::class, 'ref_id', 'kejadian_id')
                        ->where('ref_table', 'kejadian_bencana')
                        ->orderBy('sort_order')
                        ->orderBy('media_id');
        } catch (\Exception $e) {
            // Return empty collection if media table doesn't exist
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

    /**
     * Get first photo safely
     */
    public function getFirstPhotoSafely()
    {
        try {
            $media = $this->media()->first();
            return $media ? $media->file_url : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
