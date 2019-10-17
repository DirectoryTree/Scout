<?php

namespace App\Http\Requests;

use App\LdapNotifier;
use App\LdapNotifierCondition;
use App\Rules\DistinguishedName;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LdapNotifierConditionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'type' => [
                'required',
                Rule::in(array_keys(LdapNotifierCondition::types()))
            ],
            'attribute' => [
                'required',
            ],
            'operator' => [
                'required',
                Rule::in(array_keys(LdapNotifierCondition::operators()))
            ],
        ];

        // If the user has selected the contains operator,
        // we will allow the value to be nullable.
        if ($this->isNullableOperator($this->operator)) {
            $rules['value'][] = 'nullable';
        } else {
            $rules['value'][] = 'required';
        }

        // Set the validation rules depending on the selected type.
        switch ($this->type) {
            case LdapNotifierCondition::TYPE_BOOL:
                $rules['value'][] = 'bool';
                break;
            case LdapNotifierCondition::TYPE_DN:
                $rules['value'][] = new DistinguishedName();
                break;
            case LdapNotifierCondition::TYPE_INT:
                $rules['value'][] = 'integer';
                break;
            case LdapNotifierCondition::TYPE_TIMESTAMP:
                $rules['value'][] = 'date';
                break;
            case LdapNotifierCondition::TYPE_STRING:
                $rules['value'][] = 'string';
        }

        return $rules;
    }

    /**
     * Persist the LDAP notifier condition.
     *
     * @param LdapNotifier          $notifier
     * @param LdapNotifierCondition $condition
     *
     * @return LdapNotifierCondition
     */
    public function persist(LdapNotifier $notifier, LdapNotifierCondition $condition)
    {
        if (!$condition->exists) {
            $condition->notifier()->associate($notifier);
        }

        $condition->type = $this->type;
        $condition->attribute = $this->attribute;
        $condition->operator = $this->operator;

        if (!$this->isNullableOperator($this->operator)) {
            $condition->value = $this->value;
        }

        $condition->save();

        return $condition;
    }


    /**
     * Determine if the given operator can be nullable.
     *
     * @param string $operator
     *
     * @return bool
     */
    protected function isNullableOperator($operator)
    {
        return in_array($operator, [
            LdapNotifierCondition::OPERATOR_HAS,
            LdapNotifierCondition::OPERATOR_PAST,
            LdapNotifierCondition::OPERATOR_CHANGED,
        ]);
    }
}
