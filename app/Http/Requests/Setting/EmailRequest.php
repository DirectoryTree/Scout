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
        if (!$this->has('enabled')) {
            return ['enabled' => 'boolean'];
        }

        $availableDrivers = array_keys((new EmailDriverInjector)->get());

        return [
            'enabled' => 'boolean',
            'driver' => [
                Rule::in($availableDrivers)
            ],
            'host' => 'required',
            'port' => 'required|integer',
            'username' => 'required',
            'password' => [
                new RequiredIf($this->passwordIsAlreadySet()),
                'confirmed',
            ],
            'encryption' => 'nullable|in:tls,ssl',
            'from_name' => 'required',
            'from_address' => 'required',
        ];
    }

    /**
     * Determine if the the password is already set.
     *
     * @return bool
     */
    protected function passwordIsAlreadySet()
    {
        return setting()->has('app.email.password');
    }
}
