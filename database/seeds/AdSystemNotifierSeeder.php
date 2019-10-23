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
            'notifiable_name' => 'Account Expired',
            'name' => 'Notify me when accounts expire',
            'conditions' => [
                [
                    'type' => LdapNotifierCondition::TYPE_TIMESTAMP,
                    'operator' => LdapNotifierCondition::OPERATOR_PAST,
                    'attribute' => 'accountexpires',
                ],
                [
                    'type' => LdapNotifierCondition::TYPE_INTEGER,
                    'operator' => LdapNotifierCondition::OPERATOR_NOT_EQUALS,
                    'attribute' => 'accountexpires',
                    'value' => '9223372036854775807',
                ],
                [
                    'type' => LdapNotifierCondition::TYPE_INTEGER,
                    'operator' => LdapNotifierCondition::OPERATOR_NOT_EQUALS,
                    'attribute' => 'accountexpires',
                    'value' => '0',
                ],
                [
                    'type' => LdapNotifierCondition::TYPE_INTEGER,
                    'operator' => LdapNotifierCondition::OPERATOR_CHANGED,
                    'attribute' => 'accountexpires',
                ]
            ]
        ],
        [
            'notifiable_name' => 'Group Members Changed',
            'name' => 'Notify me when user group memberships change',
            'conditions' => [
                [
                    'type' => LdapNotifierCondition::TYPE_STRING,
                    'operator' => LdapNotifierCondition::OPERATOR_CHANGED,
                    'attribute' => 'member',
                ]
            ],
        ],
        [
            'notifiable_name' => 'User Password Changed',
            'name' => 'Notify me when user passwords are changed',
            'conditions' => [
                [
                    'type' => LdapNotifierCondition::TYPE_STRING,
                    'operator' => LdapNotifierCondition::OPERATOR_CHANGED,
                    'attribute' => 'pwdlastset',
                ]
            ],
        ],
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
                $notifier = LdapNotifier::firstOrNew(['notifiable_name' => $data['notifiable_name']]);

                $notifier->notifiable()->associate($domain);
                $notifier->name = $data['name'];
                $notifier->system = true;
                $notifier->save();

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
