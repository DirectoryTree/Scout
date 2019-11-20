<?php

namespace App\Http\Html;

use Spatie\Html\Elements\Input;
use Spatie\Html\Elements\Label;

class Checkbox extends Input
{
    /**
     * The toggle label.
     *
     * @var Label|null
     */
    protected $label;

    /**
     * The label for the toggle.
     *
     * @param string $label
     *
     * @return static
     */
    public function label($label)
    {
        $this->label = form()->label()
            ->for($this->getAttribute('name'))
            ->class('custom-control-label')
            ->text($label);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toHtml(): string
    {
        $label = $this->label ? $this->label->toHtml() : null;

        return $this->wrap(parent::toHtml().$label);
    }

    /**
     * Wrap the content in a div.
     *
     * @param string $content
     *
     * @return \Spatie\Html\Elements\Div
     */
    public function wrap($content)
    {
        return html()->div($content)->class(['custom-control', 'custom-checkbox']);
    }
}
