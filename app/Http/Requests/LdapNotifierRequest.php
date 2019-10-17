<?php

namespace App\Http\Requests;

use App\LdapNotifier;
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
            'name' => 'required|max:250',
            'short_name' => 'required|max:50',
            'description' => 'max:10000',
        ];
    }

    /**
     * Save an LDAP notifier.
     *
     * @param LdapNotifier $notifier
     *
     * @return LdapNotifier
     */
    public function persist(LdapNotifier $notifier)
    {
        if (!$notifier->exists) {
            $notifier->creator()->associate($this->user());
        }

        $notifier->name = $this->name;
        $notifier->notifiable_name = $this->short_name;
        $notifier->description = $this->description;

        $notifier->save();

        return $notifier;
    }
}
