<?php

return [
    'MediaTypeServices' =>
    [
        'image' => [
            'extensions' => [
                "png", "jpg", "jpeg"
            ],
            'handler' => \Yazdan\Media\Services\ImageFileService::class
        ],
        "video" => [
            "extensions" =>[
                "avi", "mp4", "mkv"
            ],
            "handler" => \Yazdan\Media\Services\VideoFileService::class,
        ],
        "zip" => [
            "extensions" => [
                "zip", "rar", "tar"
            ],
            "handler" => \Yazdan\Media\Services\ZipFileService::class
        ]
    ]
];
