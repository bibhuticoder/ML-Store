<?php

namespace App\Http\Resources\Model;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment\CommentCollectionResource;
use App\Models\ModelUpdate;

class ModelUpdateResource extends JsonResource
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
      'credits_earned' => $this->credits_earned,
      'user'           => $this->user->name,
      'model_name'     => $this->model->title,
      'model_id'       => $this->model->id,
      'created_at'     => $this->created_at->toFormattedDateString(),
    ];
  }
}
