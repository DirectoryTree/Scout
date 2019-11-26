<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LdapObject;
use App\LdapDomain;
use Faker\Generator as Faker;

$factory->define(LdapObject::class, function (Faker $faker) {
    return [
        'guid' => $faker->uuid,
        'type' => 'user',
        'values' => [],
    ];
});

$factory->afterMaking(LdapObject::class, function (LdapObject $object, Faker $faker) {
    if (!$object->domain_id) {
        $domain = factory(LdapDomain::class)->create();
        $object->domain()->associate($domain);
    }

    $object->name = $faker->name;
    $object->dn = "cn={$object->name},{$object->domain->base_dn}";
});
