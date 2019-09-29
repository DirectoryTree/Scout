<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\LdapDomain;
use App\LdapNotifier;
use Faker\Generator as Faker;

$factory->define(LdapNotifier::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->state(LdapNotifier::class, 'domain', function (Faker $faker) {
    return [
        'attribute' => $faker->word,
        'type' => $faker->randomElement(array_keys(LdapNotifier::types())),
        'operator' => $faker->randomElement(array_keys(LdapNotifier::operators())),
        'value' => $faker->word,
    ];
});

$factory->afterMakingState(LdapNotifier::class, 'domain', function (LdapNotifier $notifier, Faker $faker) {
    if (!$notifier->notifiable_id) {
        $notifier->notifiable()->associate(
            factory(LdapDomain::class)->create()
        );
    }
});
