<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'warga_id';
    
    // Make fillable dynamic based on available columns
    protected $fillable = [
        'nama',
        'no_ktp',
        'nik', // alternative to no_ktp
        'alamat',
        'rt',
        'rw',
        'no_hp',
        'telp', // alternative to no_hp
        'foto',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'email',
    ];

    /**
     * Get foto safely with fallback
     */
    public function getFotoSafely()
    {
        try {
            return $this->foto ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get phone number with column mapping
     */
    public function getPhoneAttribute()
    {
        return $this->no_hp ?? $this->telp ?? null;
    }

    /**
     * Get NIK/KTP number with column mapping
     */
    public function getNikAttribute()
    {
        return $this->no_ktp ?? $this->nik ?? null;
    }

    /**
     * Override getAttribute to handle column mapping
     */
    public function getAttribute($key)
    {
        // Handle column mapping for common field name variations
        $columnMapping = [
            'phone' => ['no_hp', 'telp'],
            'ktp' => ['no_ktp', 'nik'],
        ];

        if (isset($columnMapping[$key])) {
            foreach ($columnMapping[$key] as $column) {
                $value = parent::getAttribute($column);
                if ($value !== null) {
                    return $value;
                }
            }
            return null;
        }

        return parent::getAttribute($key);
    }
}
