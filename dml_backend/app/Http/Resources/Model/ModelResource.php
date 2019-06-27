<?php

namespace App\Http\Resources\Model;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ModelReview\ModelReviewCollectionResource;
use App\Models\ModelUpdate;
use App\Models\ModelReview;

class ModelResource extends JsonResource
{

  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'version' => $this->version,
      'description' => $this->description,
      'script_path' => 'storage/scripts/' . $this->script_path,
      'model_path' => 'storage/models/' . str_replace(".json", "", $this->model_path) . '/' . $this->model_path,
      'thumbnail_path' => url('/') . '/storage/thumbnails/' . $this->thumbnail_path,
      'credits_per_training' => $this->credits_per_training,
      'trainings_remaining' => $this->max_training_count - $this->updates()->count(),
      'reviews' => new ModelReviewCollectionResource($this->reviews),
      'user' => $this->user,
      'created_at' => $this->created_at->toFormattedDateString(),
    ];
  }
}
