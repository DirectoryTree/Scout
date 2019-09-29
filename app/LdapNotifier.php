<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapNotifier extends Model
{
    const TYPE_DN = 'dn';
    const TYPE_BOOL = 'bool';
    const TYPE_INT = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_TIMESTAMP = 'timestamp';

    const OPERATOR_EQUALS = '=';
    const OPERATOR_NOT_EQUALS = '!=';
    const OPERATOR_GREATER_THAN = '>';
    const OPERATOR_LESS_THAN = '<';
    const OPERATOR_CONTAINS = '*';

    /**
     * The belongsTo creator relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The owning notifiable models relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Get the notifier types.
     *
     * @return array
     */
    public static function types()
    {
        return [
            LdapNotifier::TYPE_DN => 'Distinguished Name',
            LdapNotifier::TYPE_INT => 'Integer',
            LdapNotifier::TYPE_BOOL => 'Boolean',
            LdapNotifier::TYPE_STRING => 'String',
            LdapNotifier::TYPE_TIMESTAMP => 'Timestamp',
        ];
    }

    /**
     * Get the notifier operators.
     *
     * @return array
     */
    public static function operators()
    {
        return [
            LdapNotifier::OPERATOR_EQUALS => 'Equals',
            LdapNotifier::OPERATOR_NOT_EQUALS => 'Does not equal',
            LdapNotifier::OPERATOR_GREATER_THAN => 'Greater than',
            LdapNotifier::OPERATOR_LESS_THAN => 'Less than',
            LdapNotifier::OPERATOR_CONTAINS => 'Contains',
        ];
    }
}
