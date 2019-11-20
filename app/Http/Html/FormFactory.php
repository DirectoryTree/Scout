<?php

namespace App\Http\Html;

use Spatie\Html\Elements\Span;
use Spatie\Html\Elements\Input;
use Spatie\Html\Elements\Label;
use Spatie\Html\Elements\Select;

class FormFactory
{
    /**
     * Create a new input element.
     *
     * @return Input
     */
    public function input()
    {
        return Input::create()->class('form-control');
    }

    /**
     * Create a new password element.
     *
     * @return Input
     */
    public function password()
    {
        return $this->input()->type('password');
    }

    /**
     * Create a new number element.
     *
     * @return Input
     */
    public function number()
    {
        return $this->input()->type('number');
    }

    /**
     * Create a new search element.
     *
     * @return Input
     */
    public function search()
    {
        return $this->input()->type('search');
    }

    /**
     * Create a new email element.
     *
     * @return Input
     */
    public function email()
    {
        return $this->input()->type('email');
    }

    /**
     * Create a new trix editor.
     *
     * @return TrixEditor
     */
    public function editor()
    {
        return TrixEditor::create();
    }

    /**
     * Create a new select element.
     *
     * @return Select
     */
    public function select()
    {
        return Select::create()->class('custom-select');
    }

    /**
     * Create a new checkbox element.
     *
     * @return Checkbox
     */
    public function checkbox()
    {
        return Checkbox::create()
            ->type('checkbox')
            ->class('custom-control-input');
    }

    /**
     * Create a new radio element.
     *
     * @return Radio
     */
    public function radio()
    {
        return Radio::create()
            ->type('radio')
            ->class('custom-control-input');
    }

    /**
     * Create a new toggler element.
     *
     * @return Toggle
     */
    public function toggle()
    {
        return Toggle::create()
            ->type('checkbox')
            ->class('custom-control-input');
    }

    /**
     * Create a new label element.
     *
     * @return Label
     */
    public function label()
    {
        return Label::create()->class('font-weight-bold');
    }

    /**
     * Create a new error element.
     *
     * @return Span
     */
    public function error()
    {
        return Span::create()
            ->class(['invalid-feedback', 'font-weight-bold']);
    }
}
