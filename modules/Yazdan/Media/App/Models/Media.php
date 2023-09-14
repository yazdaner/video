<?php
namespace Yazdan\Media\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Yazdan\Media\Services\MediaFileService;

class Media extends Model
{
    protected $table = 'media';
    protected $guarded = [];
    protected $casts = [
        'files' => 'json'
    ];

    protected static function booted()
    {
        self::deleting(function($media) {
            MediaFileService::delete($media);
        });
    }



    public function thumb($size = 'original')
    {
        return MediaFileService::thumb($this,$size);
    }


    public function download()
    {
        return URL::temporarySignedRoute('media.download',now()->addDay(),['media' => $this->id]);
    }

}


