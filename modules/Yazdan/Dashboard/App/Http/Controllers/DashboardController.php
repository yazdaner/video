<?php

namespace Yazdan\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Yazdan\Dashboard\App\Models\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('index',Dashboard::class);
        return view('Dashboard::index');
    }
}
