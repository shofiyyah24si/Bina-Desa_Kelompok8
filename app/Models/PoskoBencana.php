<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoskoBencana extends Model
{
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

    /**
     * Relasi ke media dengan error handling
     */
    public function media()
    {
        try {
            return $this->hasMany(Media::class, 'ref_id', 'posko_id')
                        ->where('ref_table', 'posko_bencana')
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
