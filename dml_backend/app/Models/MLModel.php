<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MLModel extends Model
{
  protected $table = "ml_models";
  protected $fillable = [
    'title',
    'status',
    'version', //updated version, increases each time model is updated
    'description',
    'credits_per_training',
    'max_training_count',
    'model_path', //path to model at FEDERATED server
    'thumbnail_path',
    'script_path',
    'user_id',
    'update_threshold',
    'created_at',
    'updated_at'
  ];

  public function updates()
  {
    return $this->hasMany('App\Models\ModelUpdate', 'model_id');
  }

  public function reviews()
  {
    return $this->hasMany('App\Models\ModelReview', 'model_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
}
