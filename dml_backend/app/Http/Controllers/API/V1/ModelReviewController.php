<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ModelReview;
use App\Http\Resources\ModelReview\ModelReviewResource;
use App\Http\Resources\ModelReview\ModelReviewCollectionResource;
use App\Http\Requests\ModelReviewRequest;

class ModelReviewController extends Controller
{
  
  public function __construct()
  {
    $this->middleware('jwt.auth', ['only' => [
      'store',
      'update',
      'destroy'
    ]]);
  }

  public function index($model_id)
  {
    $model = MLModel::findOrFail($model_id);
    return response()->json(new ModelReviewCollectionResource($model->reviews), 200);
  }

  public function show($id)
  {
    $modelReview = ModelReview::findOrFail($id);
    return response()->json(new ModelReviewResource($modelReview), 200);
  }
  
  public function store(Request $request, $model_id)
  {
    $request->merge(['user_id'     => $request->auth->id]);
    $request->merge(['model_id'    => $model_id]);
    $created = ModelReview::create($request->all());

    return ($created)
      ? response()->json(['message' => 'success'], 201)
      : response()->json(['message' => 'fail'], 400);
  }
  
}
