<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiLogistik extends Model
{
    protected $table = 'distribusi_logistik';
    protected $primaryKey = 'distribusi_id';

    protected $fillable = [
        'logistik_id',
        'posko_id',
        'tanggal',
        'jumlah',
        'penerima',
    ];

    public function logistik()
    {
        return $this->belongsTo(LogistikBencana::class, 'logistik_id');
    }

    public function posko()
    {
        return $this->belongsTo(PoskoBencana::class, 'posko_id');
    }

    /**
     * Relasi ke media dengan error handling
     */
    public function media()
    {
        try {
            return $this->hasMany(Media::class, 'ref_id', 'distribusi_id')
                        ->where('ref_table', 'distribusi_logistik')
                        ->orderBy('sort_order')
                        ->orderBy('media_id');
        } catch (\Exception $e) {
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
     * Add media file (consistent with other modules)
     */
    public function addMedia($file, $refTable)
    {
        try {
            if ($file->isValid()) {
                
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = "uploads/distribusi_logistik";
                
           
                $fullPath = public_path($uploadPath);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                // Upload file (sama seperti modul lain)
                $file->move($fullPath, $filename);
                
                // Simpan ke tabel media (sama seperti modul lain)
                Media::create([
                    'ref_table' => $refTable,
                    'ref_id' => $this->distribusi_id,
                    'file_url' => "distribusi_logistik/$filename",
                    'caption' => null,
                    'mime_type' => $file->getClientMimeType(),
                    'sort_order' => 0
                ]);
                
                return true;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to add media to distribusi: ' . $e->getMessage());
            return false;
        }
        
        return false;
    }

    /**
     * Delete media file (consistent with other modules)
     */
    public function deleteMedia($mediaId)
    {
        try {
            $media = Media::where('media_id', $mediaId)
                ->where('ref_table', 'distribusi_logistik')
                ->where('ref_id', $this->distribusi_id)
                ->first();
                
            if ($media) {
                $filePath = public_path('uploads/' . $media->file_url);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $media->delete();
                return true;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to delete media from distribusi: ' . $e->getMessage());
            return false;
        }
        
        return false;
    }
}
