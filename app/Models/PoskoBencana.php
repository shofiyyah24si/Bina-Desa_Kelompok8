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
     * Relasi ke media (multiple photos) - sama seperti KejadianBencana
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'posko_id')
            ->where('ref_table', 'posko_bencana')
            ->orderBy('sort_order');
    }

    /**
     * Check if posko has photos
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
        return asset('assets-admin/images/default-posko.png');
    }
}
