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
        
        // Check if we should use cloud storage
        if (config('app.use_cloud_storage', false)) {
            // Upload to cloud storage (implement your preferred service)
            $cloudUrl = $this->uploadToCloud($file, $folder, $filename);
            
            return $this->media()->create([
                'ref_table' => $this->getTable(),
                'ref_id'    => $this->getKey(),
                'file_url'  => $cloudUrl,
                'mime_type' => $file->getClientMimeType() ?? 'image/jpeg',
            ]);
        } else {
            // Local storage (back to original system)
            $uploadPath = "uploads/$folder";
            
            // Ensure directory exists
            $fullPath = public_path($uploadPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            try {
                // Move uploaded file
                $file->move($fullPath, $filename);
                
                // Log successful upload
                \Log::info('Media uploaded successfully', [
                    'ref_table' => $this->getTable(),
                    'ref_id' => $this->getKey(),
                    'filename' => $filename,
                    'folder' => $folder
                ]);
                
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
    }

    private function uploadToCloud($file, $folder, $filename)
    {
        // Example implementation for a simple cloud storage
        // You can implement Google Drive API, AWS S3, etc.
        
        // For now, we'll use a shared hosting approach
        // Upload to a shared URL that both admin and guest can access
        
        $sharedUploadPath = config('app.shared_upload_url', 'https://your-shared-storage.com/uploads/');
        
        // This is a placeholder - implement actual cloud upload logic
        // For example, using Google Drive API, AWS S3, etc.
        
        return $sharedUploadPath . $folder . '/' . $filename;
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
