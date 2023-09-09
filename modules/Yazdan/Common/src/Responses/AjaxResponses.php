<?php

namespace Yazdan\Common\Responses;

use Illuminate\Http\Response;


class AjaxResponses
{

    public static function SuccessResponses()
    {
        return response()->json(["message" => 'عملیات انجام شد'],Response::HTTP_OK);
    }

    public static function ErrorResponses()
    {
        return response()->json(["message" => 'عملیات با خطا مواجه شد'],Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
