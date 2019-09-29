<?php

namespace App\Http\Requests;

use App\LdapNotifier;
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
        return [
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
            'value' => []
        ];
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
        $notifier->value = $this->value;

        $notifier->save();

        return $notifier;
    }
}
