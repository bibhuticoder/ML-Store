<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\MLModel;
use GuzzleHttp\Client;

class AverageModels implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct($model_id)
  {
    dd("coustructor");
    $this->model = MLModel::findOrFail($model_id);
  }

  public function handle($model_id)
  {
    $model = MLModel::findOrFail($model_id);
    $weightsList = $model->updates()->map(function ($update) {
      return $update->weights;
    });

    dd($weightsList);
    return "aasd";
    // //send http request to federated server to aggregate the model
    // $fed_server_url = "http://localhost:3000/fed-average";
    // $client = new Client([
    //   'base_uri' => $fed_server_url,
    //   'timeout'  => 60,
    // ]);

    // $response = $client->post('/fed-avg', [
    //   'weightsList' =>  ''
    // ]);
    

    // after successful response, clear 'model_updates' data belonging to the model

  }
}
