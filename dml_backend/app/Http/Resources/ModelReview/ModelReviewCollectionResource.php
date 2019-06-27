<?php

namespace App\Http\Resources\ModelReview;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ModelReviewCollectionResource extends ResourceCollection
{

  public function ellipsisContent($content){
    $content_length_threshold = 100;
    if (strlen($content) > $content_length_threshold) return str_limit($content, $content_length_threshold) . '...'; 
    return $content;
  }

  public function toArray($request)
  { 
    return $this->collection->transform(function ($modelReview) {
      return [
        'id'      => $modelReview->id,
        'content' => $this->ellipsisContent($modelReview->content),
        'rating'  => $modelReview->rating,
        'user'    => [
          'name'             => $modelReview->user->username,
          'profile_pic_path' => $modelReview->user->profile_pic_path
        ],
        'created_at' => $modelReview->created_at->toFormattedDateString(),
      ];
    });
  }
}
