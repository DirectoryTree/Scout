<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\LdapDomain;
use Faker\Generator as Faker;

$factory->define(LdapDomain::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'uuid' => $faker->uuid,
        'name' => $faker->domainName,
        'slug' => $faker->slug,
        'username' => $faker->userName,
        'password' => $faker->password,
        'hosts' => [$faker->ipv4],
        'base_dn' => 'dc=local,dc=com',
    ];
});
