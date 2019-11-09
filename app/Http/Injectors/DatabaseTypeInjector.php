<?php

namespace App\Http\Injectors;

class DatabaseTypeInjector
{
    /**
     * Get the available database types.
     *
     * @return array
     */
    public function get()
    {
        return [
            'mysql' => 'MySQL',
            'pgsql' => 'PostgreSQL',
            'sqlite' => 'SQLite',
            'sqlsrv' => 'MS SQL Server',
        ];
    }
}
