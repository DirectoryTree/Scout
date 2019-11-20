<?php

namespace App\Http\Html;

class Toggle extends Checkbox
{
    /**
     * Wrap the content in a div.
     *
     * @param string $content
     *
     * @return \Spatie\Html\Elements\Div
     */
    public function wrap($content)
    {
        return html()->div($content)->class(['custom-control', 'custom-switch']);
    }
}
