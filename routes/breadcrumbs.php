<?php

Breadcrumbs::for('domains.index', function ($trail) {
    $trail->push('Domains', route('domains.index'));
});

Breadcrumbs::for('domains.create', function ($trail) {
    $trail->parent('domains.index');

    $trail->push('Add Domain', route('domains.create'));
});

Breadcrumbs::for('domains.show', function ($trail, $domain) {
    $trail->parent('domains.index');

    $trail->push($domain->name, route('domains.show', $domain));
});
