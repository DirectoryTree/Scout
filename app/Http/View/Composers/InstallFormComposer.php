<?php

namespace App\Http\View\Composers;

use Illuminate\Contracts\View\View;

class InstallFormComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return View
     */
    public function compose(View $view)
    {
        return $view->with('databases', [
            'mysql' => 'MySQL',
            'pgsql' => 'PostgreSQL',
            'sqlite' => 'SQLite',
            'sqlsrv' => 'MS SQL Server',
        ]);
    }
}
