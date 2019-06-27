<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammerDetail extends Model
{
  protected $table = "programmer_details";
  protected $fillable = [
    'full_name', 'details', 'created_at', 'updated_at'
  ];

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
}
