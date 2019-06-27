<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MLModel;
use App\Http\Resources\Model\ModelResource;
use App\Http\Resources\Model\ModelCollectionResource;
use App\Http\Requests\ModelRequest;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessModels;

class ModelController extends Controller
{

  public function __construct()
  {
    $this->middleware('is-programmer', ['only' => [
      'store',
      'update',
      'destroy'
    ]]);
  }

  public function index()
  {
    $models = MLModel::all();
    return response()->json(new ModelCollectionResource($models), 200);
  }

  public function search(Request $request)
  {
    $models =  MLModel::query()
      ->where('title', 'LIKE', "%{$request->query->keyword}%")
      ->get();
    return response()->json(new ModelCollectionResource($models), 200);
  }

  public function popular()
  {
    $models = MLModel::orderBy('version', 'DESC')->limit(5)->get();
    return response()->json(new ModelCollectionResource($models), 200);
  }

  public function show($id)
  {
    $model = MLModel::findOrFail($id);
    return response()->json(new ModelResource($model), 200);
  }

  public function store(Request $request)
  {
    $request->validate([
      'title'       => 'required',
      'description' => 'required'
    ]);

    $request->merge(['user_id' => $request->auth->id]);
    $created = MLModel::create($request->all());

    return ($created)
      ? response()->json(['message' => 'success'], 201)
      : response()->json(['message' => 'fail'], 400);
  }

  public function update(ModelRequest $request, $id)
  {
    $request->validate([
      'title'       => 'required',
      'description' => 'required'
    ]);
    
    $model = MLModel::findOrFail($id);
    $updated = $model->update($request->all());

    // when its time to aggregate the weights
    ProcessModels::dispatchNow($model);

    return ($updated)
      ? response()->json(['message' => 'success'], 200)
      : response()->json(['message' => 'fail'], 400);
  }

  public function destroy($id)
  {
    $model = MLModel::findOrFail($id);
    $deleted = $model->delete();
    return ($deleted)
      ? response()->json(['message' => 'success'], 200)
      : response()->json(['message' => 'failed'], 400);
  }
}
