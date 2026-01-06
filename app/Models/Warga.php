<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'warga_id';
    
    protected $fillable = [
        'nama',
        'no_ktp',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
        'foto_profil', // Sama seperti users, bukan 'foto'
    ];

    /**
     * Get foto URL dengan sistem public/uploads (sama seperti users)
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('uploads/' . $this->foto_profil);
        }
        return asset('assets-admin/images/default-avatar.png'); // default avatar
    }

    /**
     * Get foto safely with fallback
     */
    public function getFotoSafely()
    {
        return $this->foto_profil ?? null;
    }

    /**
     * Check if warga has photo
     */
    public function hasPhoto()
    {
        return !empty($this->foto_profil) && file_exists(public_path('uploads/' . $this->foto_profil));
    }
}
