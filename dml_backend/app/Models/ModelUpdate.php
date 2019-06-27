<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelUpdate extends Model
{
  protected $table = "model_updates";
  protected $fillable = [
    'weights_path',
    'credits_earned',
    'model_id',
    'user_id',
    'status',
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
