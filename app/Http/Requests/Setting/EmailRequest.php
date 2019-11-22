<?php

namespace App\Http\Requests\Setting;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;
use App\Http\Injectors\EmailDriverInjector;

class EmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $availableDrivers = array_keys((new EmailDriverInjector())->get());

        return [
            'enabled' => 'boolean',
            'driver' => [
                Rule::in($availableDrivers)
            ],
            'hosts' => 'required',
            'port' => 'required|integer',
            'username' => 'required',
            'password' => [new RequiredIf('')],
            'encryption' => 'nullable|in:tls,ssl',
            'from_name' => '',
            'from_address' => '',
        ];
    }
}
