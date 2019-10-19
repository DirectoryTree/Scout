<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\LdapDomain;
use App\LdapNotifier;
use App\LdapNotifierCondition;
use Faker\Generator as Faker;

$factory->define(LdapNotifier::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'system' => false,
        'enabled' => true,
        'name' => 'Notifier',
        'notifiable_name' => 'Short Name',
    ];
});

$factory->define(LdapNotifierCondition::class, function (Faker $faker) {
    return [
        'notifier_id' => function() {
            return factory(LdapNotifier::class)->create()->id;
        },
        'type' => $faker->randomElement(array_keys(LdapNotifierCondition::types())),
        'attribute' => $faker->word,
        'operator' => $faker->randomElement(array_keys(LdapNotifierCondition::operators())),
        'value' => $faker->word,
    ];
});

$factory->state(LdapNotifier::class, 'domain', function (Faker $faker) {
    return [
        'notifiable_id' => function () {
            return factory(LdapDomain::class)->create()->id;
        },
        'notifiable_type' => LdapDomain::class,
    ];
});
