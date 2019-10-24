<?php

namespace App\Http\View\Composers;

use App\LdapNotifierCondition;
use Illuminate\Contracts\View\View;

class NotifierConditionFormComposer
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
        $view->with([
            'types' => LdapNotifierCondition::types(),
            'booleans' => LdapNotifierCondition::booleans(),
            'operators' => LdapNotifierCondition::operators(),
            'nullableOperators' => LdapNotifierCondition::nullableOperators(),
        ]);
    }
}
