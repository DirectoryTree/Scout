<?php

namespace App\Ldap\Transformers;

class AttributeTransformer extends Transformer
{
    /**
     * The attribute transformer map.
     *
     * @var array
     */
    protected $map = [
        'objectsid' => ObjectSid::class,
        'pwdlastset' => WindowsIntTimestamp::class,
        'whenchanged' => WindowsTimestamp::class,
        'whencreated' => WindowsTimestamp::class,
        'dscorepropagationdata' => WindowsTimestamp::class,
    ];

    /**
     * Transform the value.
     *
     * @return mixed
     */
    public function transform(): array
    {
        foreach ($this->value as $attribute => $value) {
            if (array_key_exists($attribute, $this->map)) {
                $transformer = $this->map[$attribute];

                // Transform and replace the value with the transformed value.
                $this->value[$attribute] = (new $transformer($value))->transform();
            }
        }

        return $this->value;
    }
}
