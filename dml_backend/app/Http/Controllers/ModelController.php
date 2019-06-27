<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MLModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModelController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $models = MLModel::all();
    return view('models.list')->with('models', $models);
  }

  public function show($id)
  {
    $model = MLModel::with('reviews')->findOrFail($id);
    // $reviews = $model->reviews();
    return view('models.show', compact('model'));
  }

  public function create()
  {
    return view('models.create');
  }

  public function store(Request $request)
  {

    $request->validate([
      'title' => 'required|unique:ml_models|max:255'
    ]);
    $request->merge(['user_id' => Auth::id()]);
    $model = MLModel::create($request->all());

    if ($request->hasFile('thumbnail')) $model->thumbnail_path = $this->storeFile('thumbnail', $request, $model->id);
    if ($request->hasFile('script')) $model->script_path = $this->storeFile('script', $request, $model->id);
    if ($request->hasFile('model')) $model->model_path = $this->storeFile('model', $request, $model->id);
    $created = $model->save();

    return ($created)
      ? redirect()->route('models.index')
      : back()->with('error', 'Error creating model');
  }

  public function edit($id)
  {
    $model = MLModel::findOrFail($id);
    return view('models.edit')->with('model', $model);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'title' => 'required|unique:ml_models,id,' . $id . '|max:255'
    ]);
    $model = MLModel::findOrFail($id);
    $model->update($request->all());
    if ($request->hasFile('thumbnail')) $model->thumbnail_path = $this->storeFile('thumbnail', $request, $model->id);
    if ($request->hasFile('script')) $model->script_path = $this->storeFile('script', $request, $model->id);
    if ($request->hasFile('model')) $model->model_path = $this->storeFile('model', $request, $model->id);
    $updated = $model->save();

    return ($updated)
      ? back()->with('message', 'Model updated')
      : back()->with('error', 'Error updating model');
  }

  public function destroy($id)
  {
    MLModel::findOrFail($id)->delete();
    return back()->with('message', 'Model deleted');
  }

  public function storeFile($name, $request, $model_id)
  {
    $ext = $request->file($name)->getClientOriginalExtension();
    $foldername = 'public/' . $name . 's';
    $filename = Auth::id() . '_' . $name . '_' . $model_id . '.' . $ext;

    // json and bin file should be in one folder
    if ($name === 'model') {
      $localFolderName = Auth::id() . '_' . $name . '_' . $model_id;
      $foldername =  $foldername . '/' . $localFolderName;
      Storage::makeDirectory($foldername);
      $request->file($name)->storeAs($foldername, $filename);
      $request->file('weights')->storeAs($foldername, 'weights.bin');
      return $filename;
    }

    $request->file($name)->storeAs($foldername, $filename);
    return $filename;
  }
}
