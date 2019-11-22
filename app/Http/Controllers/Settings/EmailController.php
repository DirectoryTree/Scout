<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    public function edit()
    {
        return view('settings.email.edit');
    }
}
