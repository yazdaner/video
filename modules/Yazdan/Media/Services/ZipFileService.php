<?php

namespace Yazdan\Media\Services;

use Yazdan\Media\App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Yazdan\Media\Services\DefaultFileService;
use Yazdan\Media\Contracts\FileServiceContract;

class ZipFileService extends DefaultFileService implements FileServiceContract
{
    public static $sizes = ['60','300','600'];

    public static function upload($file, $dir, $filename) :array
    {
        $fileFullName = $filename . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($dir,$file,$fileFullName);
        return ['zip' => $fileFullName];
    }

    public static function thumb(Media $media,string $size){
        return asset('img/zip-thumb.png');
    }

    public static function getFilename()
    {
        return self::$media->access . '/' . self::$media->files['zip'];

    }
}








