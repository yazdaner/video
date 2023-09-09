<?php

function newFeedbackes($title = 'با موفقعیت',$body = 'عملیات انجام شد',$type = 'success')
{
    $session = session()->has('feedbacks') ? session()->get('feedbacks') : [] ;
    $session[] = ['title' => $title, 'body' => $body, 'type' => $type];
    session()->flash('feedbacks',$session);
}

function providerGetRoute($path,$controller,$method,$name){

    return Route::get($path,['uses' => $controller.'@'.$method ,'as' => $name]);
}
