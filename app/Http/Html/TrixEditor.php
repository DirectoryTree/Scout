<?php

namespace App\Http\Html;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Html\Attributes;
use Spatie\Html\Elements\Input;

class TrixEditor extends Input
{
    /**
     * The trix editor tag.
     *
     * @var string
     */
    protected $tag = 'trix-editor';

    /**
     * {@inheritDoc}
     */
    public function toHtml() : string
    {
        // Trix requires a unique ID set for each instance. In case
        // we do not have an ID, we will generate a unique one.
        $id = $this->getTrixId();

        // For proper rendering of the trix editor, we must
        // add a hidden attribute with the HTML content.
        $hidden = html()->hidden()->id($id)->attributes($this->getHiddenAttributes());

        // Clear all attributes.
        $this->attributes = (new Attributes())->setAttributes($this->getTrixAttributes());
        $this->attributes->setAttribute('input', $id);

        // Prepend the hidden input element.
        return $hidden->toHtml().parent::toHtml();
    }

    /**
     * Get the attributes for the hidden input element.
     *
     * @return array
     */
    protected function getHiddenAttributes()
    {
        return Arr::only($this->attributes->toArray(), ['value', 'name', 'id']);
    }

    /**
     * Get the trix element ID, or generate a unique one.
     *
     * @return string
     */
    protected function getTrixId()
    {
        return $this->getAttribute('id', 'trix-'.Str::random(5));
    }

    /**
     * Get the valid trix editor attributes.
     *
     * @return array
     */
    protected function getTrixAttributes()
    {
        return Arr::only($this->attributes->toArray(), ['placeholder', 'autofocus']);
    }
}
