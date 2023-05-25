<?php

namespace GlebRed\LaravelVueSimpleComments\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'commentable_id' => $this->commentable_id,
            'commentable_type' => $this->commentable_type,
            'user' => $this->user,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }



}
