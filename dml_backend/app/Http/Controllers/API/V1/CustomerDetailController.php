<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProgrammerDetail;
use App\Http\Requests\ProgrammerDetailRequest;

class CustomerDetailController extends Controller
{
  
  public function __construct()
  {
    $this->middleware('is-programmer', ['only' => [
      'update'
    ]]);
  }
  
  public function show(Request $request)
  {
    $detail = $request->auth()->details;
    return $detail;
  }

  public function update(Request $request, $model_id)
  {
    $updated = $request->auth()->detail()->update($request->all());

    return ($updated)
      ? response()->json(['message' => 'success'], 201)
      : response()->json(['message' => 'fail'], 400);
  }
  
  // models that user has trained
  public function models(Request $request){
    return $updates = $request->auth->updates;
  }
  
  // model updates belonging to the user
  public function updates(Request $request){
    return $request->auth->updates;
  }
  
}
