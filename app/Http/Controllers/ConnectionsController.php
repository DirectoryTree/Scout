<?php

namespace App\Http\Controllers;

use App\LdapConnection;
use App\Http\Requests\LdapConnectionRequest;

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

    /**
     * Create a new LDAP connection.
     *
     * @param LdapConnectionRequest $request
     * @param LdapConnection        $connection
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LdapConnectionRequest $request, LdapConnection $connection)
    {
        $connection->creator()->associate($request->user());

        $connection->type = $request->type;
        $connection->name = $request->name;
        $connection->hosts = explode(',', $request->hosts);
        $connection->port = $request->port;
        $connection->base_dn = $request->base_dn;
        $connection->username = $request->username;
        $connection->password = $request->password;
        $connection->save();

        flash()->success('Added LDAP connection.');

        return redirect()->route('connections.index');
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
