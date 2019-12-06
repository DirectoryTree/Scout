<?php

namespace App\System;

use Spatie\ArrayToXml\ArrayToXml;

trait GeneratesXml
{
    /**
     * The XML template.
     *
     * @return array
     */
    abstract public function template();

    /**
     * The root XML attributes.
     *
     * @return array
     */
    public function rootAttributes()
    {
        return [];
    }

    /**
     * Generates XML based on the template.
     *
     * @return string
     */
    public function toXml()
    {
        return ArrayToXml::convert(
            $this->template(),
            $this->rootAttributes(),
            $replaceSpacesByUnderScoresInKeyNames = true,
            $xmlEncoding = 'UTF-16',
            $xmlVersion = '1.0',
            ['formatOutput' => true]
        );
    }
}
