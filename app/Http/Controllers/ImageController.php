<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{

    public function storeImage($imageFile, $name, $folder)
    {
        $extension = $imageFile->getClientOriginalExtension();
        $newFilename = Str::slug(substr($name, 0, 100), '-') . '-' . Str::uuid() . ".$extension";

        $imageFile->storeAs("images/$folder", $newFilename, 'public');

        return $newFilename;
    }

    public function replaceImage($newImageFile, $oldImageFilename, $name, $folder)
    {
        if ($oldImageFilename && Storage::disk('public')->exists("images/$folder/$oldImageFilename")) {
            Storage::disk('public')->delete("images/$folder/$oldImageFilename");
            return self::storeImage($newImageFile, $name, $folder);
        } else {
            throw new \Exception('Gambar tidak ditemukan');
        }
    }

    public function getImage($filename, $folder)
    {
        $path = "images/$folder/$filename";

        if (Storage::disk('public')->exists($path)) {
            return response()->file(storage_path('app/public/' . $path));
        }

        return response()->json(['error' => 'Gambar tidak ditemukan'], 404);
    }
}
