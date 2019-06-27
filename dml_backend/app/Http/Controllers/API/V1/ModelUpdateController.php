<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MLModel;
use App\Models\ModelUpdate;
use App\Http\Requests\ModelUpdateRequest;
use App\Http\Resources\ModelUpdate\ModelUpdateCollectionResource;
use App\Jobs\AverageModels;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

class ModelUpdateController extends Controller
{
  public function __construct()
  {
    $this->middleware('jwt.auth', ['only' => [
      'index', 'store'
    ]]);
  }

  public function index(Request $request)
  {
    $updates = ModelUpdate::where('user_id', $request->auth->id)->orderBy('created_at', 'DESC')->get();
    return response()->json(new ModelUpdateCollectionResource($updates), 200);
  }

  public function store(Request $request, $model_id)
  {
    $request->merge(['user_id'     => $request->auth->id]);
    $request->merge(['model_id'    => $model_id]);

    $model = MLModel::findOrFail($model_id);
    $credits_earned = floatval($model->credits_per_training) * floatval($request->input('accuracy'));
    $request->merge(['credits_earned' => $credits_earned]);

    if ($request->hasFile('weights')) {
      $file_name = Auth::id() . '_update_' . round(microtime(true) * 1000) . '_.bin';
      $request->file('weights')->storeAs('public/updates', $file_name);
      $request->merge(['weights_path' => $file_name]);
    }
    $created = ModelUpdate::create($request->all());

    if ($model->updates()->where('status', 0)->count() <= $model->update_threshold) {
      return response()->json(['message' => 'success'], 200);
    }

    // else average weights
    $weightPaths = $model->updates()->where('status', 0)->get()->map(function ($update) {
      return $update->weights_path;
    })->toJson();

    //send http request to federated server to aggregate the model
    $client = new Client([
      'base_uri' => "http://localhost:3000/",
      'timeout'  => 3600,
    ]);
    $response = $client->request('POST', 'http://localhost:3000/fed-average', [
      'form_params' => [
        'update_paths' => $weightPaths,
        'model_path'   => $model->model_path,
        'model_id'     => $model->id
      ]
    ]);
    return response()->json(['message' => $response], 200);
  }

  public function verify(Request $request)
  {
    // update model version
    $model_id = $request->input("model_id");
    $model = MLModel::findOrFail($model_id);
    $model->version = $model->version + 1;
    $model->save();

    // give credit to users and delete all updates files
    $update_paths = $request->input("update_paths");
    $update_paths = json_decode($update_paths, true);
    foreach ($update_paths as $update_path) {
      $model_update = ModelUpdate::where('weights_path', $update_path)->first();
      $model_update->user->credits = $model_update->user->credits + $model_update->credits_earned;
      $model_update->user->save();
      $model_update->status = 1;
      $model_update->save();
      Storage::delete('./public/updates/' . $model_update->weights_path);
    }
    return response()->json(['message' => 'success'], 200);
  }
}
