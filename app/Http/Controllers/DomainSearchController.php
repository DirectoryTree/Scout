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
            $query = $domain->objects()
                ->where('name', 'like', "%{$term}%")
                ->orderBy('name');

            if ($request->deleted) {
                $query->withTrashed();
            }

            $objects = $query->paginate(25);
        }

        return view('domains.search.index', compact('domain', 'objects'));
    }
}
