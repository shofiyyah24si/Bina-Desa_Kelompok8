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

        // For uploads paths - these are typically media files stored in public/uploads
        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        // For relative paths (like kejadian_bencana/filename.jpg from media table)
        // Check if file exists in public/uploads directory first
        if (file_exists(public_path('uploads/' . $path))) {
            return asset('uploads/' . $path);
        }

        // Check if file exists in storage directory
        if (file_exists(storage_path('app/public/' . $path))) {
            return asset('storage/' . $path);
        }

        // Default: assume it's in uploads directory
        return asset('uploads/' . $path);
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
        if (empty($path)) {
            return asset($fallback);
        }

        // Check if it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // For Laravel storage paths (stored as uploads/users/filename.jpg)
        // These are stored in storage/app/public/uploads/users/filename.jpg
        // and accessed via storage/uploads/users/filename.jpg
        if (str_starts_with($path, 'uploads/')) {
            // Check if file exists in storage
            $storagePath = storage_path('app/public/' . $path);
            if (file_exists($storagePath)) {
                return asset('storage/' . $path);
            }
            
            // Check if file exists in public uploads (backup location)
            $publicPath = public_path($path);
            if (file_exists($publicPath)) {
                return asset($path);
            }
        }

        // For direct storage paths
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // If no file found, return fallback
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