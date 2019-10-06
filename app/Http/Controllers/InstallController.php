<?php

namespace App\Http\Controllers;

use App\Installer\Requirements;
use App\Http\Requests\InstallRequest;

class InstallController extends Controller
{
    /**
     * Displays the installation page with requirements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('installer.index', [
            'requirements' => (new Requirements())->get(),
        ]);
    }

    public function store(InstallRequest $request)
    {
        redirect()->back();
    }
}
