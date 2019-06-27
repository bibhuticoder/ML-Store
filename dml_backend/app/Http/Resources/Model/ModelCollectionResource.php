<?php

namespace App\Http\Resources\Model;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ModelCollectionResource extends ResourceCollection
{
  /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
  public function toArray($request)
  {
    return $this->collection->transform(function ($model) {
      return [
        'id' => $model->id,
        'title' => $model->title,
        'version' => $model->version,
        'credits_per_training' => $model->credits_per_training,
        'ratings' => $this->calcRating($model->reviews),
        'thumbnail_path' => url('/') . '/storage/thumbnails/' . $model->thumbnail_path
      ];
    });
  }

  public function calcRating($reviews){
    $total = 0;
    $count = count($reviews);
    foreach ($reviews as $review) {
      $total += $review->rating;
    }
    return ($total/($count + 1));
  }
}
