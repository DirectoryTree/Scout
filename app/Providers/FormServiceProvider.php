<?php

namespace App\Providers;

use Collective\Html\FormFacade;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register the form macros.
     */
    public function boot()
    {
        FormFacade::macro('scoutLabel', function ($name, $value = '', $attributes = []) {
            return view('forms.label', compact('name', 'value', 'attributes'));
        });

        FormFacade::macro('scoutError', function ($name) {
            return view('forms.error', compact('name'));
        });

        FormFacade::macro('scoutInput', function ($type, $name = '', $value = '', $attributes = []) {
            return view('forms.input', compact('type', 'name', 'value', 'attributes'));
        });

        FormFacade::macro('scoutSelect', function ($name, $options = [], $default = '', $attributes = []) {
            return view('forms.select', compact('name', 'options', 'default', 'attributes'));
        });

        FormFacade::macro('scoutPassword', function ($name, $attributes = []) {
            return FormFacade::scoutInput('password', $name, null, $attributes);
        });

        FormFacade::macro('scoutText', function ($name, $value = '', $attributes = []) {
            return FormFacade::scoutInput('text', $name, $value, $attributes);
        });

        FormFacade::macro('scoutEmail', function ($name, $value = '', $attributes = []) {
            return FormFacade::scoutInput('email', $name, $value, $attributes);
        });

        FormFacade::macro('scoutSearch', function ($name, $value = '', $attributes = []) {
            return FormFacade::scoutInput('search', $name, $value, $attributes);
        });

        FormFacade::macro('scoutCheckbox', function ($name, $value = '', $checked = false, $attributes = []) {
            $label = Arr::pull($attributes, 'label');

            if ($checked) {
                $attributes['checked'] = 'checked';
            }

            return view('forms.checkbox', compact('name', 'value', 'label', 'attributes'));
        });
    }
}
