<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LdapScan;
use App\LdapDomain;
use App\LdapScanEntry;
use Faker\Generator as Faker;

$factory->define(LdapScan::class, function (Faker $faker) {
    return array(
        'domain_id' => function () {
            return factory(LdapDomain::class)->create()->id;
        },
    );
});

$factory->define(LdapScanEntry::class, function (Faker $faker) {
    return [
        'scan_id' => function () {
            return factory(LdapScan::class)->create()->id;
        },
        'guid' => $faker->uuid,
        'type' => 'user',
        'values' => [],
        'ldap_updated_at' => now(),
    ];
});

$factory->afterMaking(LdapScanEntry::class, function (LdapScanEntry $entry, Faker $faker) {
    $entry->name = $faker->name;
    $entry->dn = "cn={$entry->name},{$entry->scan->domain->base_dn}";
});
