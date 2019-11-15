<?php

Breadcrumbs::for('domains.index', function ($trail) {
    $trail->push('Domains', route('domains.index'));
});

Breadcrumbs::for('domains.create', function ($trail) {
    $trail->parent('domains.index');

    $trail->push('Add Domain', route('domains.create'));
});

Breadcrumbs::for('domains.edit', function ($trail, $domain) {
    $trail->parent('domains.show', $domain);

    $trail->push('Edit', route('domains.edit', $domain));
});

Breadcrumbs::for('domains.show', function ($trail, $domain) {
    $trail->parent('domains.index');

    $trail->push($domain->name, route('domains.show', $domain));
});

Breadcrumbs::for('domains.delete', function ($trail, $domain) {
    $trail->parent('domains.show', $domain);

    $trail->push('Delete', route('domains.delete', $domain));
});

Breadcrumbs::for('domains.search.index', function ($trail, $domain) {
    $trail->parent('domains.show', $domain);

    $trail->push('Search', route('domains.search.index', $domain));
});

Breadcrumbs::for('domains.notifiers.index', function ($trail, $domain) {
    $trail->parent('domains.show', $domain);

    $trail->push('Notifiers', route('domains.notifiers.index', $domain));
});

Breadcrumbs::for('domains.notifiers.create', function ($trail, $domain) {
    $trail->parent('domains.notifiers.index', $domain);

    $trail->push('Add', route('domains.notifiers.create', $domain));
});

Breadcrumbs::for('domains.notifiers.show', function ($trail, $domain, $notifier) {
    $trail->parent('domains.notifiers.index', $domain);

    $trail->push($notifier->notifiable_name, route('domains.notifiers.show', [$domain, $notifier]));
});

Breadcrumbs::for('domains.notifiers.edit', function ($trail, $domain, $notifier) {
    $trail->parent('domains.notifiers.show', $domain, $notifier);

    $trail->push('Edit', route('domains.notifiers.edit', [$domain, $notifier]));
});

Breadcrumbs::for('domains.notifiers.conditions.index', function ($trail, $domain, $notifier) {
    $trail->parent('domains.notifiers.show', $domain, $notifier);

    $trail->push('Conditions', route('domains.notifiers.show', [$domain, $notifier]));
});

Breadcrumbs::for('domains.notifiers.logs.index', function ($trail, $domain, $notifier) {
    $trail->parent('domains.notifiers.show', $domain, $notifier);

    $trail->push('Logs', route('domains.notifiers.logs.index', [$domain, $notifier]));
});

Breadcrumbs::for('domains.notifiers.logs.show', function ($trail, $domain, $notifier, $log) {
    $trail->parent('domains.notifiers.show', $domain, $notifier);

    $trail->push("# {$log->getKey()}", route('domains.notifiers.logs.show', [$domain, $notifier, $log]));
});

Breadcrumbs::for('domains.changes.index', function ($trail, $domain) {
    $trail->parent('domains.show', $domain);

    $trail->push('All Changes', route('domains.changes.index', $domain));
});

Breadcrumbs::for('domains.changes.show', function ($trail, $domain, $attribute) {
    $trail->parent('domains.changes.index', $domain);

    $trail->push($attribute, route('domains.changes.show', [$domain, $attribute]));
});

Breadcrumbs::for('domains.scans.index', function ($trail, $domain) {
    $trail->parent('domains.show', $domain);

    $trail->push('Scans', route('domains.scans.index', $domain));
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

Breadcrumbs::for('domains.objects.attributes.index', function ($trail, $domain, $object) {
    $trail->parent('domains.objects.show', $domain, $object);

    $trail->push('Attributes', route('domains.objects.attributes.index', [$domain, $object]));
});

Breadcrumbs::for('domains.objects.changes.index', function ($trail, $domain, $object) {
    $trail->parent('domains.objects.show', $domain, $object);

    $trail->push('Changes', route('domains.objects.changes.index', [$domain, $object]));
});

Breadcrumbs::for('domains.objects.changes.show', function ($trail, $domain, $object, $attribute) {
    $trail->parent('domains.objects.changes.index', $domain, $object);

    $trail->push($attribute, route('domains.objects.changes.show', [$domain, $object, $attribute]));
});
