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
        'foto_profil', // Sama seperti users, warga, dan kejadian_bencana
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id');
    }

    /**
     * Get foto URL dengan sistem public/uploads (sama seperti users, warga, dan kejadian_bencana)
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('uploads/' . $this->foto_profil);
        }
        return asset('assets-admin/images/default-posko.png'); // default posko image
    }

    /**
     * Get foto safely with fallback
     */
    public function getFotoSafely()
    {
        return $this->foto_profil ?? null;
    }

    /**
     * Check if posko has photo
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
