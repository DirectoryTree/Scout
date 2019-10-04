<?php

namespace App\Http\Requests;

use App\LdapNotifier;
use App\LdapNotifierCondition;
use App\Rules\DistinguishedName;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class LdapNotifierRequest extends FormRequest
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
     * Persist the LDAP notifier.
     *
     * @param LdapNotifier $notifier
     * @param Model        $notifiable
     *
     * @return LdapNotifier
     */
    public function persist(LdapNotifier $notifier, Model $notifiable)
    {
        if (!$notifier->exists) {
            $notifier->notifiable()->associate($notifiable);
            $notifier->creator()->associate($this->user());
        }

        if ($this->has('name') || $this->isEmptyString('name')) {
            $notifier->name = $this->getGeneratedName();
        }

        $notifier->type = $this->type;
        $notifier->attribute = $this->attribute;
        $notifier->operator = $this->operator;

        // We don't need the value if the operator is set to "past".
        if ($this->operator != LdapNotifierCondition::OPERATOR_PAST) {
            $notifier->value = $this->value;
        }

        $notifier->save();

        return $notifier;
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
            LdapNotifierCondition::OPERATOR_PAST
        ]);
    }

    /**
     * @return string
     */
    protected function getGeneratedName()
    {
        return "Notify me when $this->attribute $this->operator $this->value";
    }
}
