<?php

namespace Yazdan\Media\Repositories;

class MediaRepository
{
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_AUDIO = 'audio';
    const TYPE_ZIP = 'zip';
    const TYPE_DOC = 'doc';

    static $types = [self::TYPE_IMAGE,self::TYPE_VIDEO,self::TYPE_AUDIO,self::TYPE_ZIP,self::TYPE_DOC];


    const ACCESS_PUBLIC = 'public';
    const ACCESS_PRIVATE = 'private';

    static $access = [self::ACCESS_PUBLIC,self::ACCESS_PRIVATE];

}



