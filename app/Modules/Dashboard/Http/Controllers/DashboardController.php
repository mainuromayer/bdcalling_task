<?php

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('backend.index');
    }
}
