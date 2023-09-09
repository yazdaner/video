<?php

namespace Yazdan\Media\App\Http\Controllers;

use Illuminate\Http\Request;
use Yazdan\Media\App\Models\Media;

use App\Http\Controllers\Controller;
use Yazdan\Media\Services\MediaFileService;

use function PHPUnit\Framework\returnSelf;

class MediaController extends Controller
{
    public function download(Media $media,Request $request)
    {
        if(!$request->hasValidSignature()){
            return abort(401);
        }
        return MediaFileService::stream($media);
    }
}

