<?php

use Illuminate\Database\Seeder;

use App\LdapDomain;
use App\LdapNotifier;
use App\LdapNotifierCondition;

class AdSystemNotifierSeeder extends Seeder
{
    /**
     * The system notifiers to seed.
     *
     * @var array
     */
    protected $notifiers = [
        [
            'name' => 'Notify me when accounts expire',
            'conditions' => [
                [
                    'type' => LdapNotifierCondition::TYPE_TIMESTAMP,
                    'operator' => LdapNotifierCondition::OPERATOR_PAST,
                    'attribute' => 'accountexpires',
                ]
            ]
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Here we will loop through our ActiveDirectory domains
        // and seed our system notifiers so users can easily
        // toggle them on in the notifications section.
        LdapDomain::where('type', '=', LdapDomain::TYPE_ACTIVE_DIRECTORY)->get()->each(function (LdapDomain $domain) {
            foreach ($this->notifiers as $data) {
                /** @var LdapNotifier $notifier */
                $notifier = tap(LdapNotifier::firstOrNew(['name' => $data['name']]), function (LdapNotifier $notifier) use ($domain) {
                    $notifier->notifiable()->associate($domain);
                    $notifier->system = true;
                    $notifier->save();
                });

                foreach ($data['conditions'] as $condition) {
                    $notifier->conditions()->firstOrCreate([
                        'type' => $condition['type'],
                        'operator' => $condition['operator'],
                        'attribute' => $condition['attribute'],
                        'value' => array_key_exists('value', $condition) ? $condition['value'] : null,
                    ]);
                }
            }
        });
    }
}
