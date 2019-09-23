<?php

namespace App\Http\Controllers;

use App\LdapDomain;
use Illuminate\Http\Request;

class DomainSearchController
{
    /**
     * Displays the search form.
     *
     * @param Request    $request
     * @param LdapDomain $domain
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, LdapDomain $domain)
    {
        $objects = null;

        if ($term = $request->term) {
            $objects = $domain->objects()
                ->where('name', 'like', "%{$term}%")
                ->orderBy('name')
                ->paginate(25);
        }

        return view('domains.search.index', compact('domain', 'objects'));
    }
}
