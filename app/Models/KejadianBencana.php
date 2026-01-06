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
        'foto_profil', // Tambahkan foto_profil ke fillable
    ];

    /**
     * Get photo URL safely
     */
    public function getPhotoUrl()
    {
        if ($this->foto_profil) {
            return asset('uploads/' . $this->foto_profil);
        }
        return null;
    }

    /**
     * Check if has photo
     */
    public function hasPhoto()
    {
        return !empty($this->foto_profil);
    }
}
