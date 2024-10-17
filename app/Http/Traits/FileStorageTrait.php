<?php
namespace App\Http\Traits;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait FileStorageTrait
{
    public function storeFile($file, string $folderName)
    {
        $originalName = $file->getClientOriginalName();

        // Check for double extensions in the file name
        if (preg_match('/\.[^.]+\./', $originalName)) {
            throw new Exception(trans('general.notAllowedAction'), 403);
        }

        // Validate the mime type and extensions
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jfif'];
        $allowedExtensions = ['jpeg', 'png', 'gif', 'jpg', 'jfif'];
        $mime_type = $file->getClientMimeType();
        $extension = $file->getClientOriginalExtension();

        if (!in_array($mime_type, $allowedMimeTypes) || !in_array($extension, $allowedExtensions)) {
            throw new Exception(trans('general.invalidFileType'), 403);
        }

        // Sanitize the file name to prevent path traversal
        $fileName = Str::random(32);
        $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '', $fileName);

        // Store the file in the public disk
        $path = $file->storeAs($folderName, $fileName . '.' . $extension, 'public');

        // Get the URL of the stored file
        $url = Storage::url($path);

        return $url;
    }
}
?>
