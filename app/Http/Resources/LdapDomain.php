<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LdapDomain extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'base_dn' => $this->base_dn,
            'type' => $this->type,
        ];
    }
}
