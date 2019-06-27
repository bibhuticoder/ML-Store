<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelReview extends Model
{
  protected $table = "model_reviews";
  protected $fillable = [
    'content',
    'rating',
    'model_id',
    'user_id',
    'created_at',
    'updated_at'
  ];

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

  public function model()
  {
    return $this->belongsTo('App\Models\MLModel', 'model_id');
  }
}
