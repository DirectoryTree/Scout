<?php

namespace App\Http\View\Composers;

use App\LdapChange;
use App\LdapDomain;
use Illuminate\Contracts\View\View;

class DomainLayoutComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        /** @var LdapDomain $domain */
        $domain = request()->domain;

        $data = ['counts' => [
            'objects' => $domain->objects()->count(),
            'changes' => LdapChange::whereHas('object', function ($query) use ($domain) {
                return $query->whereIn('object_id', $domain->objects()->get('id'));
            })->count()
        ]];

        if ($objectId = request()->object) {
            $object = $domain->objects()->findOrFail($objectId);

            $data['counts']['object'] = [
                'attributes' => count($object->attributes),
                'changes' => $object->changes()->count(),
            ];
        }

        $view->with($data);
    }
}
