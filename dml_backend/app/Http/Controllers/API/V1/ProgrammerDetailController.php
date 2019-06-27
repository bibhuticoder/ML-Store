<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ModelReview;
use App\Http\Resources\ModelReview\ModelReviewResource;
use App\Http\Resources\ModelReview\ModelReviewCollectionResource;
use App\Http\Requests\ModelReviewRequest;

class ProgrammerDetailController extends Controller
{
  
  public function __construct()
  {
    $this->middleware('is-customer', ['only' => [
      'update'
    ]]);
  }
  
  public function show(Request $request){
    $detail = $request->auth()->details;
    return $detail;
  }

  public function update(Request $request, $model_id)
  {
    $request->merge(['user_id'     => $request->auth->id]);
    $request->merge(['model_id'    => $model_id]);
    $created = ModelReview::create($request->all());

    return ($created)
      ? response()->json(['message' => 'success'], 201)
      : response()->json(['message' => 'fail'], 400);
  }
  
  public function models(Request $request){
    return $updates = $request->auth->updates;
  }
  
  public function updates(Request $request){
    return $request->auth->updates->pluck();
  }
  
}
