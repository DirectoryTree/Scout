<?php

namespace App\Http\Controllers;

use App\LdapChange;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $changes = LdapChange::query()
            ->select('ldap_updated_at')
            ->whereBetween('ldap_updated_at', [now()->subMonths(2), now()])
            ->get()
            ->groupBy(function (LdapChange $change) {
                return $change->ldap_updated_at->format('Y-m-d');
            })->transform(function ($changes) {
                 return $changes->count();
            });

        $months = [now()->subMonths(2), now()->subMonth(), now()];

        return view('dashboard', compact('months', 'changes'));
    }
}
