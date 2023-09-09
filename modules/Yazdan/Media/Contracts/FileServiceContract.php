<?php

namespace Yazdan\Media\Contracts;

use Illuminate\Http\UploadedFile;
use Yazdan\Media\App\Models\Media;


interface FileServiceContract
{
    public static function upload(UploadedFile $file, string $dir, string $filename): array;

    public static function delete(Media $media);

    public static function stream(Media $media);

    public static function thumb(Media $media,string $size);
}
