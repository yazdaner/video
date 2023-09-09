<?php

namespace Yazdan\Media\Services;

use Illuminate\Http\UploadedFile;
use Yazdan\Media\App\Models\Media;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yazdan\Media\Services\DefaultFileService;
use Yazdan\Media\Contracts\FileServiceContract;

class VideoFileService extends DefaultFileService implements FileServiceContract
{

    public static function upload($file, $dir, $filename): array
    {
        $fileFullName = $filename .'.'. $file->getClientOriginalExtension();
        Storage::putFileAs($dir, $file, $fileFullName);
        return ['video' => $fileFullName];
    }
    public static function thumb(Media $media,string $size){
        return asset('img/video-thumb.png');
    }

    public static function getFilename()
    {
        return self::$media->access . '/' . self::$media->files['video'];
    }

}
