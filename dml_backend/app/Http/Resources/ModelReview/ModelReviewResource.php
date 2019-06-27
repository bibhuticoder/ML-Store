<?php

namespace App\Http\Resources\ModelReview;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment\CommentCollectionResource;
use App\Models\ModelUpdate;
use App\Models\ModelReview;

class ModelReviewResource extends JsonResource
{
  /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'content' => $this->content,
      'rating' => $this->rating,
      'user' => $this->user,
      'created_at' => $this->created_at->toFormattedDateString(),
    ];
  }
}
