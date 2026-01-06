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

        // Check if it's already a full URL (cloud storage)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
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

        // Try shared storage URL for guest access (for AlwaysData hosting)
        $sharedUrl = config('app.shared_storage_url');
        if ($sharedUrl) {
            return rtrim($sharedUrl, '/') . '/uploads/' . $path;
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

        // For Laravel paths (stored as uploads/users/filename.jpg or users/filename.jpg)
        if (str_starts_with($path, 'uploads/')) {
            // Check if file exists in public uploads
            $publicPath = public_path($path);
            if (file_exists($publicPath)) {
                $url = asset($path);
                $timestamp = filemtime($publicPath);
                $url .= '?v=' . $timestamp;
                return $url;
            }
        } else {
            // Check if file exists in public/uploads/path
            $publicPath = public_path('uploads/' . $path);
            if (file_exists($publicPath)) {
                $url = asset('uploads/' . $path);
                $timestamp = filemtime($publicPath);
                $url .= '?v=' . $timestamp;
                return $url;
            }
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