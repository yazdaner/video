<?php

namespace Yazdan\Media\Services;

use Illuminate\Http\UploadedFile;
use Yazdan\Media\App\Models\Media;
use Yazdan\Media\Contracts\FileServiceContract;
use Yazdan\Media\Repositories\MediaRepository;

class MediaFileService
{

    private static $file;
    private static $dir;
    private static $access;

    public static function publicUpload(UploadedFile $file)
    {
        self::$dir = 'public/';
        self::$file =  $file;
        self::$access = MediaRepository::ACCESS_PUBLIC;
        return self::upload();
    }

    public static function privateUpload(UploadedFile $file)
    {
        self::$dir = 'private/';
        self::$file =  $file;
        self::$access = MediaRepository::ACCESS_PRIVATE;
        return self::upload();
    }

    private static function upload()
    {
        $ext = self::getLowerExtention(self::$file);
        foreach (config('MediaFile.MediaTypeServices') as $type => $service) {
            if (in_array($ext, $service['extensions'])) {
                return self::uploadByHandler(new $service['handler'], $type);
            }
        }
    }

    public static function delete(Media $media)
    {
        foreach (config('MediaFile.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::delete($media);
            }
        }
    }

    private static function uploadByHandler(FileServiceContract $service, $type)
    {
        $uploadedFile = $service::upload(self::$file, self::$dir, self::generateFilename());

        $media = Media::create([
            'user_id' => auth()->id(),
            'filename' => self::$file->getClientOriginalName(),
            'files' => $uploadedFile,
            'type' => $type,
            'access' => self::$access,
        ]);
        return $media;
    }

    public static function getLowerExtention(UploadedFile $file)
    {
        return strtolower($file->getClientOriginalExtension());
    }

    public static function generateFilename()
    {
        return uniqid();
    }


    public static function thumb(Media $media,string $size)
    {
        foreach (config('MediaFile.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::thumb($media,$size);
            }
        }
    }

    public static function stream(Media $media)
    {
        foreach (config('MediaFile.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::stream($media);
            }
        }
    }

}
