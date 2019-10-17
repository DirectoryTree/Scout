<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LdapNotifier extends JsonResource
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
            'notifiable_name' => $this->notifiable_name,
            'notifiable_id' => $this->notifiable_id,
            'notifiable_type' => $this->notifiable_type,
            'all_users' => $this->all_users,
        ];
    }
}
