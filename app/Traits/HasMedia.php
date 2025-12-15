<?php

namespace App\Traits;

use App\Models\Media;

trait HasMedia
{
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id')
            ->where('ref_table', $this->getTable())
            ->orderBy('sort_order', 'asc')
            ->orderBy('media_id', 'asc');
    }

    public function addMedia($file, $folder = null)
    {
        if (!$folder) {
            $folder = $this->getTable();
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $uploadPath = "uploads/$folder";
        
        // Ensure directory exists
        $fullPath = public_path($uploadPath);
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        try {
            // Move uploaded file
            $file->move($fullPath, $filename);
            
            // Create media record
            return $this->media()->create([
                'ref_table' => $this->getTable(),
                'ref_id'    => $this->getKey(),
                'file_url'  => "$folder/$filename",
                'mime_type' => $file->getClientMimeType() ?? 'image/jpeg',
            ]);
        } catch (\Exception $e) {
            // Log error and throw exception
            \Log::error('File upload failed: ' . $e->getMessage());
            throw new \Exception('Gagal mengupload file: ' . $e->getMessage());
        }
    }

    public function deleteMedia($mediaId)
    {
        $media = $this->media()->where('media_id', $mediaId)->first();
        if ($media) {
            $filePath = public_path('uploads/' . $media->file_url);
            if (file_exists($filePath)) {
                try {
                    unlink($filePath);
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete file: ' . $filePath . ' - ' . $e->getMessage());
                }
            }
            $media->delete();
        }
    }
}
