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
        'foto_profil', // Sama seperti users dan warga
    ];

    /**
     * Get foto URL dengan sistem public/uploads (sama seperti users dan warga)
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('uploads/' . $this->foto_profil);
        }
        return asset('assets-admin/images/default-disaster.png'); // default disaster image
    }

    /**
     * Get foto safely with fallback
     */
    public function getFotoSafely()
    {
        return $this->foto_profil ?? null;
    }

    /**
     * Check if kejadian has photo
     */
    public function hasPhoto()
    {
        return !empty($this->foto_profil) && file_exists(public_path('uploads/' . $this->foto_profil));
    }

    /**
     * Get photo URL safely (alias untuk compatibility)
     */
    public function getPhotoUrl()
    {
        return $this->getFotoUrlAttribute();
    }
}
