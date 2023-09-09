<?php

namespace Yazdan\Media\Services;

use Yazdan\Media\App\Models\Media;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yazdan\Media\Services\DefaultFileService;
use Yazdan\Media\Contracts\FileServiceContract;

class ImageFileService extends DefaultFileService implements FileServiceContract
{
    public static $sizes = ['60', '300', '600'];


    public static function upload($file, $dir, $filename): array
    {
        $fileFullName = $filename . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($dir, $file, $fileFullName);
        return static::resize($fileFullName, $dir);
    }

    public static function resize($file, $dir)
    {
        $img = Image::make(Storage::path($dir) . $file);
        $images['original'] = $file;
        foreach (static::$sizes as $size) {
            $img->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileSizeName = $size . '_' . $file;
            $fileSizePath = Storage::path($dir) . $fileSizeName;
            $img->save($fileSizePath);
            $images[$size] = $fileSizeName;
        }

        return $images;
    }


    public static function thumb(Media $media, $size)
    {

        $a = collect(ImageFileService::$sizes)->map(function ($item) use ($size) {
            return $size == $item;
        });

        if (
            !in_array(true, $a->toArray()) &&
            !Storage::disk('local')->exists('public/' . $media->files[$size])
        ) $size = 'original';
        return env('BANNER_PATH') . $media->files[$size];
    }

    public static function getFilename()
    {
        return self::$media->access . '/' . self::$media->files['original'];
    }
}
