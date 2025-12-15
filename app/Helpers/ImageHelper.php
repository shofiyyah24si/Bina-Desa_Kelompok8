<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the full URL for an uploaded image
     */
    public static function getImageUrl($path, $default = null)
    {
        if (empty($path)) {
            return $default ? asset($default) : asset('assets-admin/images/profile/sofia.png');
        }

        // Check if it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // For storage paths (storage/...)
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // For uploads paths (uploads/...)
        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        // For relative paths, assume it's in storage
        return asset('storage/' . $path);
    }

    /**
     * Check if image file exists
     */
    public static function imageExists($path)
    {
        if (empty($path)) {
            return false;
        }

        // Check in public/uploads
        if (file_exists(public_path('uploads/' . $path))) {
            return true;
        }

        // Check in storage/app/public
        if (file_exists(storage_path('app/public/' . $path))) {
            return true;
        }

        return false;
    }

    /**
     * Get image with fallback
     */
    public static function getImageWithFallback($path, $fallback = 'assets-admin/images/profile/sofia.png')
    {
        if (self::imageExists($path)) {
            return self::getImageUrl($path);
        }

        return asset($fallback);
    }

    /**
     * Debug image path
     */
    public static function debugImagePath($path)
    {
        $info = [
            'original_path' => $path,
            'public_uploads_exists' => file_exists(public_path('uploads/' . $path)),
            'storage_public_exists' => file_exists(storage_path('app/public/' . $path)),
            'public_uploads_path' => public_path('uploads/' . $path),
            'storage_public_path' => storage_path('app/public/' . $path),
            'generated_url' => self::getImageUrl($path),
        ];

        return $info;
    }
}