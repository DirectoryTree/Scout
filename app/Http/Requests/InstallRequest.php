<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class InstallRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'driver' => 'required|in:mysql,sqlite,sqlsrv,pgsql',
            'host' => 'required',
            'port' => 'required|integer',
            'database' => 'required',
            'username' => 'required',
            'password' => 'nullable',
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
            // If the validator still contains errors, we will bail out until
            // all rules pass, and then continue with connection validation.
            if ($validator->messages()->count() > 0) {
                return;
            }

            try {
                /** @var \Illuminate\Database\Connectors\ConnectionFactory $factory */
                $factory = app('db.factory');

                $factory->make($validator->validated())->getPdo();
            } catch (Exception $ex) {
                $validator->errors()->add('host', $ex->getMessage());
            }
        });
    }
}
