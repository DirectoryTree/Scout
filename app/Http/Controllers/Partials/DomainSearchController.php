<?php

namespace App\Http\Controllers\Partials;

use App\Scout;
use App\LdapDomain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DomainSearchController extends Controller
{
    /**
     * Performs an LDAP domain object search an returns the HTML results.
     *
     * @param Request   $request
     * @param LdapDomain $domain
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request, LdapDomain $domain)
    {
        $this->validate($request, ['term' => 'required']);

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

        return Scout::response()->render(
            view('domains.search.partials.results', compact('domain', 'objects'))
        )->into('search-results');
    }
}
