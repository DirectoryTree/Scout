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

        $extra = [];

        switch ($this->driver) {
            case 'mailgun':
                $extra = [
                    'mailgun_domain' => ['required'],
                    'mailgun_secret' => ['required'],
                    'mailgun_endpoint' => ['required'],
                ];
                break;
            case 'ses':
                $extra = [
                    'ses_key' => ['required'],
                    'ses_secret' => ['required'],
                ];
                break;
        }

        return array_merge($this->baseRules(), $extra);
    }

    /**
     * Get the base email validation rules.
     *
     * @return array
     */
    protected function baseRules()
    {
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
                new RequiredIf($this->passwordHasNotBeenSet()),
                'confirmed',
            ],
            'encryption' => 'nullable|in:tls,ssl',
            'from_name' => 'required',
            'from_address' => 'required',
        ];
    }

    /**
     * Determine if the the email password is not yet set.
     *
     * @return bool
     */
    protected function passwordHasNotBeenSet()
    {
        return !setting()->has('app.email.password');
    }
}
