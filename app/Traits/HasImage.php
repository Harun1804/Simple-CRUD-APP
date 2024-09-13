<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage($imageFile, $path)
    {
        $directory = 'public/' . $path;

        // Check if the directory exists, if not, create it
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $imageFile->storeAs($directory, $imageFile->hashName());
    }

    public function removeImage($imageName, $path)
    {
        Storage::disk('local')->delete('public/'.$path.'/'.basename($imageName));
    }

    public function updateImage($imageFile, $imageName, $path)
    {
        $this->removeImage($imageName, $path);
        $this->uploadImage($imageFile, $path);
    }
}
