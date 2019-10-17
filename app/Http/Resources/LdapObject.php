<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LdapObject extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'domain_id' => $this->domain_id,
            'parent_id' => $this->parent_id,
            'guid' => $this->guid,
            'name' => $this->name,
            'type' => $this->type,
            'icon' => $this->icon,
            'values' => $this->values,
            'domain' => LdapDomain::make($this->domain),
        ];
    }
}
