<?php

namespace App\Http\Controllers\Partials;

use App\Scout;
use App\LdapDomain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Perform a global search on all domains.
     *
     * @param Request $request
     *
     * @return \App\Http\ScoutResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
        $this->validate($request, ['term' => 'required']);

        $objects = null;

        $results = collect();

        if ($term = $request->term) {
            foreach (LdapDomain::all() as $domain) {
                $objects = $domain->objects()
                    ->where('name', 'like', "%{$term}%")
                    ->orderBy('name')
                    ->get();

                $results->add([
                    'domain' => $domain,
                    'objects' => $objects,
                ]);
            }
        }

        // Sort the results by the total result count.
        $results = $results->sortByDesc(function ($results) {
            return $results['objects']->count();
        });

        return Scout::response()->render(
            view('search.partials.results', compact('results'))
        )->into('global-search-results');
    }
}
