<?php

namespace Yazdan\Home\App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('users.profile');
    }
}
