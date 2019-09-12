<?php

namespace App\Http\Controllers;

use App\LdapConnection;

class ConnectionsController extends Controller
{
    /**
     * Displays a list of configured connections.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $connections = LdapConnection::all();

        return view('connections.index', compact('connections'));
    }

    /**
     * Displays the form for creating the connection.
     *
     * @param LdapConnection $connection
     *
     * @return \Illuminate\View\View
     */
    public function create(LdapConnection $connection)
    {
        return view('connections.create', compact('connection'));
    }

    public function store()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
