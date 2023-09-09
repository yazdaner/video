<?php

namespace Yazdan\Media\Services;

use Yazdan\Media\App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

abstract class DefaultFileService
{
    public static $media;
    public static function delete(Media $media)
    {
        foreach ($media->files as $file) {
            File::delete(Storage::path("{$media->access}/") . $file);
        }
    }

    abstract static function getFilename();

    public static function stream(Media $media)
    {
        self::$media = $media;
        $stream = Storage::readStream(static::getFilename());

        return response()->stream(function () use ($stream) {
            while(ob_get_level() > 0) ob_get_flush();
            fpassthru($stream);
        },
            200,
            [
                "Content-Type" => Storage::mimeType(static::getFilename()),
                "Content-disposition" => "attachment; filename='" . self::$media->filename ."'"
            ]
        );
    }
}
