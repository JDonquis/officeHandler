<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "code" => $this->code,
            "status_id" => $this->status_id,
            "status_name" => $this->status->name,
            "title" => $this->title,
            "user_id" => $this->user_id,
            "user_name" => $this->user->name,
            "user_last_name" => $this->user->last_name,
            "today_date" => $this->today_date,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "location_id" => $this->location_id,
            "location_name" => $this->location->name,
            "office_id" => $this->office_id,
            "office_name" => $this->office->name,
            "division_id" => $this->division_id,
            "division_name" => $this->division->name,
            "department_id" => $this->department_id,
            "department_name" => $this->department->name,
            "progress" => $this->progress,
            "observation" => $this->observation,
        ];
    }
}
