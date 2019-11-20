<?php

namespace App\Http\Html;

class Radio extends Checkbox
{
    /**
     * {@inheritDoc}
     */
    public function wrap($content)
    {
        return html()->div($content)->class(['custom-control', 'custom-radio']);
    }
}
