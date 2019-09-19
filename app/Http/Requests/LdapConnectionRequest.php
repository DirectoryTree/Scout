<?php

namespace App\Http\Requests;

use LdapRecord\Connection;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Rules\DistinguishedName;
use LdapRecord\LdapRecordException;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LdapConnectionRequest extends FormRequest
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
                Rule::unique('ldap_connections', 'name')->ignore($this->connection)
            ],
            'hosts' => 'required',
            'username' => 'required',
            'password' => 'required',
            'base_dn' => ['required', new DistinguishedName()],
            'port' => 'required|integer',
            'timeout' => 'required|integer|max:50',
            'use_ssl' => 'sometimes|required_without:use_tls|boolean',
            'use_tls' => 'sometimes|required_without:use_ssl|boolean',
        ];
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
