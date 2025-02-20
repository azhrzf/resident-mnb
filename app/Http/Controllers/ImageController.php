<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{

    public static function storeImage($imageFile, $name, $folder)
    {
        $extension = $imageFile->getClientOriginalExtension();
        $newFilename = Str::slug(substr($name, 0, 100), '-') . '-' . Str::uuid() . ".$extension";

        $imageFile->storeAs("images/$folder", $newFilename, 'public');

        return $newFilename;
    }

    public static function replaceImage($newImageFile, $oldImageFilename, $name, $folder)
    {
        if ($oldImageFilename && Storage::disk('public')->exists("images/$folder/$oldImageFilename")) {
            Storage::disk('public')->delete("images/$folder/$oldImageFilename");
            return self::storeImage($newImageFile, $name, $folder);
        } else {
            throw new \Exception('Image not found');
        }
    }

    public static function getImage($filename, $folder)
    {
        $path = "images/$folder/$filename";

        if (Storage::disk('public')->exists($path)) {
            return response()->file(storage_path('app/public/' . $path));
        }

        return response()->json(['error' => 'Image not found'], 404);
    }
}
