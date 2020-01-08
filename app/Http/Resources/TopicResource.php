<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->resource->addHidden(['category_id', 'user_id']);
        $data = parent::toArray($request);
        $data['user'] = new UserResource($this->user);
        $data['category'] = new CategoryResource($this->category);
        return $data;
    }
}
