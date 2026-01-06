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
        'foto',
    ];

    /**
     * Get foto URL dengan sistem public/uploads
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('uploads/' . $this->foto);
        }
        return asset('assets-admin/images/default-avatar.png'); // default avatar
    }

    /**
     * Get foto safely with fallback
     */
    public function getFotoSafely()
    {
        return $this->foto ?? null;
    }

    /**
     * Check if warga has photo
     */
    public function hasPhoto()
    {
        return !empty($this->foto) && file_exists(public_path('uploads/' . $this->foto));
    }
}
