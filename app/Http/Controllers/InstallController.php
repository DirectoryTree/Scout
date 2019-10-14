<?php

namespace App\Http\Controllers;

use Exception;
use App\Installer\Installer;
use App\Installer\Requirements;
use App\Http\Requests\InstallRequest;
use Illuminate\Support\Facades\Artisan;

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
            'installer' => app(Installer::class),
            'requirements' => app(Requirements::class),
        ]);
    }

    /**
     * Store the application configuration.
     *
     * @param InstallRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InstallRequest $request)
    {
        if (!app(Requirements::class)->passes()) {
            return redirect()->route('install.index')
                ->with('error', __('Your server does not pass all of the application requirements.'));
        }

        /** @var Installer $installer */
        $installer = app(Installer::class);

        try {
            $installer->install($request->validated());
        } catch (Exception $ex) {
            return redirect()->route('install.index')
                ->with('error', "Error: " . $ex->getMessage());
        }

        return response()->turbolinks(route('install.index'));
    }

    /**
     * Run the application migrations.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function migrate()
    {
        Artisan::call('migrate');

        return redirect()->to('/login');
    }
}
