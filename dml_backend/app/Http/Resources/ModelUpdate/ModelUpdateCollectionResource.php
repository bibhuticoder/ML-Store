<?php

namespace App\Http\Resources\ModelUpdate;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ModelUpdateCollectionResource extends ResourceCollection
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return $this->collection->transform(function ($modelUpdate) {
      return [
        'id'             => $modelUpdate->id,
        'credits_earned' => $modelUpdate->credits_earned,
        'model_name'     => $modelUpdate->model->title,
        'model_id'       => $modelUpdate->model->id,
        'created_at'     => $modelUpdate->created_at->toFormattedDateString(),
      ];
    });
  }
}
