<?php


namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Image;

class ImageUploadHelper
{
    public static function saveImage($image, $fileNameUpload, $path, $drive)
    {
        Image::make($image)->save($path . $fileNameUpload);
        return $drive . $fileNameUpload;
    }

    public static function uploadImage($uploadImage, $path)
    {
        $image = $uploadImage;
        $ext = $image->getClientOriginalExtension();
        $randomString = mt_rand(1000, 9999);
        $fileName = $image->getClientOriginalName();
        $fileNameUpload = time() . "-" . $randomString . '.' . $ext;
        $drive = $path;
        $path = public_path($drive);
        if (!file_exists($path)) {
            File::makeDirectory($path, 0777, true);
        }
        $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $path, $drive);
        return $imageSave;
    }

    public static function uploadFile($uploadFile, $path)
    {
        $audioFile = $uploadFile;
        $fileName = time() . '_' . $audioFile->getClientOriginalName();
        $fileName = preg_replace('/\s+/', ' ', trim($fileName));
        $fileName = str_replace(' ', '_', $fileName);
        $drive = $path;
        $path = public_path($drive);
        if (!file_exists($path)) {
            File::makeDirectory($path, 0777, true);
        }
        $audioFile->move($path, $fileName);
        return $drive . $fileName;
    }

    public static function trim_word($text, $length, $startPoint = 0, $allowedTags = "")
    {
        $text = html_entity_decode(htmlspecialchars_decode($text));
        $text = strip_tags($text, $allowedTags);
        if (strlen($text) > $length) {
            return $text = substr($text, $startPoint, $length) . "...";
        } else {
            return $text = substr($text, $startPoint, $length);
        }
    }
}
