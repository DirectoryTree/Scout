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

        FormFacade::macro('scoutError', function ($attributes = []) {
            return view('forms.error', compact('attributes'));
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

        FormFacade::macro('scoutNumber', function ($name, $value = '', $attributes = []) {
            return FormFacade::scoutInput('number', $name, $value, $attributes);
        });

        FormFacade::macro('scoutEmail', function ($name, $value = '', $attributes = []) {
            return FormFacade::scoutInput('email', $name, $value, $attributes);
        });

        FormFacade::macro('scoutSearch', function ($name, $value = '', $attributes = []) {
            return FormFacade::scoutInput('search', $name, $value, $attributes);
        });

        FormFacade::macro('scoutSelector', function ($name, $value = '', $selected = false, $type = 'checkbox', $attributes = []) {
            $label = Arr::pull($attributes, 'label');

            if ($selected) {
                $attributes['checked'] = 'checked';
            }

            return view('forms.selector', compact('name', 'value', 'label', 'type', 'attributes'));
        });

        FormFacade::macro('scoutCheckbox', function ($name, $value = '', $checked = false, $attributes = []) {
            return FormFacade::scoutSelector($name, $value, $checked, 'checkbox', $attributes);
        });

        FormFacade::macro('scoutRadio', function ($name, $value = '', $checked = false, $attributes = []) {
            return FormFacade::scoutSelector($name, $value, $checked, 'radio', $attributes);
        });
    }
}
