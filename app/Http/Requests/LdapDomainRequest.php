<?php

namespace App\Http\Requests;

use App\LdapDomain;
use LdapRecord\Connection;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Rules\DistinguishedName;
use LdapRecord\LdapRecordException;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LdapDomainRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:1,2,3',
            'name' => [
                'required',
                'max:20',
                Rule::unique('ldap_domains', 'name')->ignore($this->domain)
            ],
            'hosts' => 'required',
            'username' => 'required',
            'password' => 'required',
            'base_dn' => ['required', new DistinguishedName()],
            'port' => 'required|integer',
            'timeout' => 'required|integer|max:50',
            'encryption' => 'nullable|in:tls,ssl',
        ];
    }

    /**
     * Save the LDAP domain information.
     *
     * @param LdapDomain $domain
     *
     * @return LdapDomain
     */
    public function persist(LdapDomain $domain)
    {
        if (!$domain->exists) {
            $domain->creator()->associate($this->user());
        }

        $domain->type = $this->type;
        $domain->name = $this->name;
        $domain->slug = Str::slug($this->name);
        $domain->hosts = explode(',', $this->hosts);
        $domain->port = $this->port;
        $domain->base_dn = $this->base_dn;
        $domain->username = $this->username;
        $domain->password = $this->password;
        $domain->encryption = $this->encryption ?? null;

        $domain->save();

        return $domain;
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $config = $this->getLdapConfiguration($validator->validated());

            try {
                (new Connection($config))->connect();
            } catch (LdapRecordException $ex) {
                $validator->errors()->add('hosts', $ex->getMessage());
            }
        });
    }

    /**
     * Get the LDAP configuration values from the given validated data.
     *
     * @param array $validated
     *
     * @return array
     */
    protected function getLdapConfiguration(array $validated)
    {
        $validated['hosts'] = explode(',', $validated['hosts']);
        $validated['use_ssl'] = $validated['encryption'] == 'ssl';
        $validated['use_tls'] = $validated['encryption'] == 'tls';

        // Override the timeout for testing connectivity.
        $validated['timeout'] = 5;

        return Arr::only($validated, [
            'hosts',
            'username',
            'password',
            'base_dn',
            'port',
            'timeout',
            'use_ssl',
            'use_tls',
        ]);
    }
}
