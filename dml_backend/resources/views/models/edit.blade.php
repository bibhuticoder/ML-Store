@extends('adminlte::page')

@section('title', 'Edit Model')

@section('content')
<form method="POST" action="/models/{{$model->id}}" enctype="multipart/form-data">
  <div class="box box-solid">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Model</h3>
    </div>
      <div class="box-body">

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title">Model Title</label>
            <input type="text" class="form-control" name="title" placeholder="Model title" value="{{$model->title}}">
            </div>

            <div class="form-group">
              <label for="credits_per_training">Credit Per Training</label>
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="number" min="0" step="0.000000001" class="form-control" name="credits_per_training" placeholder="Credit per training" value="{{$model->credits_per_training}}">
                <span class="input-group-addon">.00</span>
              </div>
            </div>

            <div class="form-group">
              <label for="max_training_count">Max Training Count</label>
              <input type="number" class="form-control" name="max_training_count" placeholder="Max Training Count" value="{{$model->max_training_count}}">
            </div>

          <div class="form-group">
            <label for="update_threshold">Update threshold(no. of updates to average)</label>
            <input type="number" class="form-control" name="update_threshold" placeholder="Update threshold" value="{{$model->update_threshold}}">
          </div>

            <div class="form-group">
              <label for="script">Upload Script</label>
              <input type="file" name="script" class="form-control">
            </div>

            <div class="form-group">
              <label for="model">Upload Model</label>
              <input type="file" name="model" class="form-control">
              <label for="model">Upload Model Weights</label>
              <input type="file" name="weights" class="form-control">
            </div>
            <div class="form-group">
              <label for="thumbnail">Upload Thumbnail</label>
              <input type="file" name="thumbnail" class="form-control">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" class="form-control" rows="22" id="ckeditor">
                {{$model->description}}
              </textarea>
            </div>
          </div>
        </div>

      </div>
      <div class="box-footer">
        {{ csrf_field() }}
        {{method_field('PUT')}}
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
  </div>
</form>
@stop