<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'number' => $this->series . '-' . $this->number,
            'date_of_issue' => optional($this->date_of_issue)->format('Y-m-d')
        ];
    }
}
