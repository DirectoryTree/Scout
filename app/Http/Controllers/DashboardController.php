<?php

namespace App\Http\Controllers;

use App\LdapChange;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $changes = LdapChange::query()
            ->whereBetween('ldap_updated_at', [now()->subMonths(2), now()])
            ->select(['ldap_updated_at', 'updated_at'])
            ->get()
            ->groupBy(function (LdapChange $change) {
                /** @var \Carbon\Carbon $date */
                $date = $change->ldap_updated_at ?? $change->updated_at;

                return $date->format('Y-m-d');
            })->transform(function ($changes) {
                 return $changes->count();
            });

        $months = [now()->subMonths(2), now()->subMonth(), now()];

        return view('dashboard', compact('months', 'changes'));
    }
}
