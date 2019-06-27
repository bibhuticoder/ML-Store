<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
  protected $table = "customer_details";
  protected $fillable = [
    'full_name', 'created_at', 'updated_at'
  ];

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
}
