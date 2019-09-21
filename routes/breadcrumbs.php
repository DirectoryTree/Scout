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

Breadcrumbs::for('domains.objects.index', function ($trail, $domain) {
    $trail->parent('domains.show', $domain);

    $trail->push('Objects', route('domains.objects.index', $domain));
});

Breadcrumbs::for('domains.objects.show', function ($trail, $domain, $object) {
    if ($object->parent) {
        $trail->parent('domains.objects.show', $domain, $object->parent);
    } else {
        $trail->parent('domains.objects.index', $domain);
    }

    $trail->push($object->name, route('domains.objects.show', [$domain, $object]));
});
