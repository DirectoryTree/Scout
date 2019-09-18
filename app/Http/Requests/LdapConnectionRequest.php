<?php

namespace App\Http\Requests;

use App\Rules\DistinguishedName;
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
            'name' => 'required|max:20',
            'hosts' => 'required|array',
            'username' => 'required',
            'password' => 'required',
            'base_dn' => ['required', new DistinguishedName()],
            'port' => 'required|integer|max:5',
            'timeout' => 'required|integer|max:50',
            'use_ssl' => 'sometimes|required_without:use_tls|boolean',
            'use_tls' => 'sometimes|required_without:use_ssl|boolean',
        ];
    }
}
