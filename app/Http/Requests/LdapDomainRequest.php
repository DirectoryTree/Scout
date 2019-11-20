<?php

namespace App\Http\Requests;

use App\LdapDomain;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Rules\LdapSearchFilter;
use App\Rules\DistinguishedName;
use LdapRecord\LdapRecordException;
use Illuminate\Validation\Validator;
use App\Ldap\Connectors\ConfigConnector;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

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
            'password' => [new RequiredIf(!$this->domain)],
            'base_dn' => ['required', new DistinguishedName()],
            'filter' => ['nullable', new LdapSearchFilter()],
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
        $domain->filter = $this->filter;
        $domain->username = $this->username;
        $domain->password = $this->password;
        $domain->encryption = $this->encryption ?? null;
        $domain->write_back = $this->write_back ?? false;

        // Set the domains initial status.
        $domain->status = LdapDomain::STATUS_ONLINE;
        $domain->attempted_at = now();

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
            // If the validator still contains errors, we will avoid
            // checking connectivity until all rules pass.
            if ($validator->messages()->count() > 0) {
                return;
            }

            // Here we will attempt to bind to the configured LDAP server.
            // Upon failure, we will add the exception message directly
            // to the hosts validation error messages so the user has
            // a clear indicator of any issues binding.
            $config = $this->getLdapConfiguration($validator->validated());

            /** @var \App\Ldap\Connectors\ConfigConnector $connector */
            $connector = app(ConfigConnector::class)->with($config);

            try {
                $connector->connect();
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
        $validated['hosts'] = explode(',', Arr::get($validated, 'hosts'));
        $validated['use_ssl'] = Arr::get($validated, 'encryption') == 'ssl';
        $validated['use_tls'] = Arr::get($validated, 'encryption') == 'tls';

        // Here we will override the configured timeout for
        // testing connectivity to the LDAP server.
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
