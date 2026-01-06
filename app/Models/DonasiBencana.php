<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;

class DonasiBencana extends Model
{
    use HasMedia;
    
    protected $table = 'donasi_bencana';
    protected $primaryKey = 'donasi_id';

    protected $fillable = [
        'kejadian_id',
        'donatur_nama',
        'jenis',
        'nilai',
        'keterangan_barang',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kejadian()
    {
        return $this->belongsTo(KejadianBencana::class, 'kejadian_id', 'kejadian_id');
    }

    /**
     * Relasi ke media dengan error handling
     */
    public function media()
    {
        try {
            return $this->hasMany(Media::class, 'ref_id', 'donasi_id')
                        ->where('ref_table', 'donasi_bencana')
                        ->orderBy('sort_order')
                        ->orderBy('media_id');
        } catch (\Exception $e) {
            \Log::warning('Media relation error in DonasiBencana: ' . $e->getMessage());
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
            \Log::warning('Failed to get media for DonasiBencana: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get formatted nilai for display
     */
    public function getFormattedNilaiAttribute()
    {
        if ($this->jenis === 'uang' && $this->nilai) {
            return 'Rp ' . number_format($this->nilai, 0, ',', '.');
        }
        return null;
    }

    /**
     * Get jenis display name
     */
    public function getJenisDisplayAttribute()
    {
        return ucfirst($this->jenis);
    }

    /**
     * Scope for filtering by jenis
     */
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    /**
     * Scope for filtering by kejadian
     */
    public function scopeByKejadian($query, $kejadianId)
    {
        return $query->where('kejadian_id', $kejadianId);
    }
}