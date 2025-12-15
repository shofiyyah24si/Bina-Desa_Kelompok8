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

        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $path = "uploads/$folder/$filename";

        // Buat folder kalau belum ada
        if (!file_exists(public_path("uploads/$folder"))) {
            mkdir(public_path("uploads/$folder"), 0777, true);
        }

        $file->move(public_path("uploads/$folder"), $filename);

        return $this->media()->create([
            'ref_table' => $this->getTable(),
            'ref_id'    => $this->getKey(),
            'file_url'  => "$folder/$filename",
            'mime_type' => $file->getClientMimeType(),
        ]);
    }

    public function deleteMedia($mediaId)
    {
        $media = $this->media()->where('media_id', $mediaId)->first();
        if ($media) {
            $filePath = public_path('uploads/' . $media->file_url);
            if (file_exists($filePath)) unlink($filePath);
            $media->delete();
        }
    }
}
