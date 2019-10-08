<?php

namespace App\Ldap\Transformers;

use Illuminate\Support\Arr;

class AttributeTransformer extends Transformer
{
    /**
     * The attribute transformer map.
     *
     * @var array
     */
    protected $map = [
        'objectsid' => ObjectSid::class,
        'accountexpires' => WindowsIntTimestamp::class,
        'pwdlastset' => WindowsIntTimestamp::class,
        'lockouttime' => WindowsIntTimestamp::class,
        'badpasswordtime' => WindowsIntTimestamp::class,
        'whenchanged' => WindowsTimestamp::class,
        'whencreated' => WindowsTimestamp::class,
        'dscorepropagationdata' => WindowsTimestamp::class,
    ];

    /**
     * Transform the value.
     *
     * @return array
     */
    public function transform(): array
    {
        // Here we will go through each LDAP attribute and attempt
        // converting the value depending on the attribute map.
        foreach ($this->value as $attribute => $value) {
            if (array_key_exists($attribute, $this->map)) {
                $transformer = $this->map[$attribute];

                // Transform and replace the value with the transformed value.
                $this->value[$attribute] = (new $transformer(Arr::wrap($value)))->transform();
            }
        }

        return $this->value;
    }
}
