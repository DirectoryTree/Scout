<?php

namespace App\Http\Requests;

use App\LdapNotifier;
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
                Rule::in(array_keys(LdapNotifier::types()))
            ],
            'attribute' => [
                'required',
            ],
            'operator' => [
                'required',
                Rule::in(array_keys(LdapNotifier::operators()))
            ],
        ];

        // If the user has selected the contains operator,
        // we will allow the value to be nullable.
        if (in_array($this->operator, [LdapNotifier::OPERATOR_CONTAINS, LdapNotifier::OPERATOR_PAST])) {
            $rules['value'][] = 'nullable';
        } else {
            $rules['value'][] = 'required';
        }

        // Set the validation rules depending on the selected type.
        switch ($this->type) {
            case LdapNotifier::TYPE_BOOL:
                $rules['value'][] = 'bool';
                break;
            case LdapNotifier::TYPE_DN:
                $rules['value'][] = new DistinguishedName();
                break;
            case LdapNotifier::TYPE_INT:
                $rules['value'][] = 'integer';
                break;
            case LdapNotifier::TYPE_TIMESTAMP:
                $rules['value'][] = 'date';
                break;
            case LdapNotifier::TYPE_STRING:
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

        $notifier->type = $this->type;
        $notifier->attribute = $this->attribute;
        $notifier->operator = $this->operator;

        // We don't need the value if the operator is set to "past".
        if ($this->operator != LdapNotifier::OPERATOR_PAST) {
            $notifier->value = $this->value;
        }

        $notifier->save();

        return $notifier;
    }
}
