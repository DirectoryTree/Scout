<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LdapNotifierCondition extends Model
{
    /**
     * The condition types.
     */
    const TYPE_DN = 'dn';
    const TYPE_BOOL = 'bool';
    const TYPE_INTEGER = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_TIMESTAMP = 'timestamp';

    /**
     * The condition booleans.
     */
    const BOOLEAN_AND = 'and';
    const BOOLEAN_OR = 'or';

    /**
     * The condition operators.
     */
    const OPERATOR_EQUALS = '=';
    const OPERATOR_NOT_EQUALS = '!=';
    const OPERATOR_GREATER_THAN = '>';
    const OPERATOR_LESS_THAN = '<';
    const OPERATOR_CONTAINS = '%';
    const OPERATOR_HAS = '*';
    const OPERATOR_PAST = '>>';
    const OPERATOR_CHANGED = '!*';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'operator',
        'attribute',
        'value',
    ];

    /**
     * Get the notifier operators.
     *
     * @return array
     */
    public static function operators()
    {
        return [
            static::OPERATOR_EQUALS => 'Equals',
            static::OPERATOR_NOT_EQUALS => 'Does not equal',
            static::OPERATOR_GREATER_THAN => 'Greater than',
            static::OPERATOR_LESS_THAN => 'Less than',
            static::OPERATOR_CONTAINS => 'Contains',
            static::OPERATOR_HAS => 'Has',
            static::OPERATOR_PAST => 'Is Past',
            static::OPERATOR_CHANGED => 'Changed',
        ];
    }

    /**
     * Get the notifier types.
     *
     * @return array
     */
    public static function types()
    {
        return [
            static::TYPE_DN => 'Distinguished Name',
            static::TYPE_INTEGER => 'Integer',
            static::TYPE_BOOL => 'Boolean',
            static::TYPE_STRING => 'String',
            static::TYPE_TIMESTAMP => 'Timestamp',
        ];
    }

    /**
     * Get the notifier booleans.
     *
     * @return array
     */
    public static function booleans()
    {
        return [
            static::BOOLEAN_AND => 'And',
            static::BOOLEAN_OR => 'Or',
        ];
    }

    /**
     * The belongsTo notifier relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notifier()
    {
        return $this->belongsTo(LdapNotifier::class, 'notifier_id');
    }

    public function getOperatorNameAttribute()
    {
        return static::operators()[$this->operator];
    }

    /**
     * Mutator for the value attribute.
     *
     * @param string $value
     *
     * @return Carbon|bool
     */
    public function getValueAttribute($value)
    {
        if (!empty($value)) {
            switch ($this->type) {
                case static::TYPE_TIMESTAMP:
                    return new Carbon($value);
                case static::TYPE_BOOL:
                    return $value == '1';
            }
        }

        return $value;
    }
}
