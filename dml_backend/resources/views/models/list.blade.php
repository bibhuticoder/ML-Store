@extends('adminlte::page')

@section('title', 'All Models')

@section('content')
<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"> All Models </h3>
    <a href="/models/create" class="btn btn-primary pull-right">Add New Model</a>
  </div>
  <div class="box-body">
    <table class="table">
      <thead>
        <th>Sn.</th>
        <th>Title</th>
        <th>Status</th>
        <th>Version</th>
        <th>Updated At</th>
        <th></th>
      </thead>
      <tbody>
        @foreach ($models as $count => $model)
          <tr>
            <td>{{ $count + 1 }}</td>
            <td>
              <a href="/models/{{$model->id}}">
                {{ $model->title }}
              </a>
            </td>
            <td>{{ $model->status }}</td>
            <td>{{ $model->version }}</td>
            <td>{{ $model->updated_at->toDateTimeString() }}</td>
            <td>
              <a href="/models/{{$model->id}}/edit" class="btn btn-sm btn-primary">Edit</a>
              <button 
                class="btn btn-sm btn-danger" 
                data-toggle="modal" 
                onclick="deleteModel({{$model->id}})"
                data-target="#delete-modal">
                  Delete
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="delete-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Delete ML Model</h4>
      </div>
      <div class="modal-body">
        <p>
          Deleting the model will delete all the updates, 
          comments and uploaded files. Are you sure you want to delete ?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        {{-- delete button --}}
        <form action="" method="POST" id="form-delete">
            {{method_field('DELETE')}}
            {{ csrf_field() }}
            <input type="submit" class="btn btn-sm btn-danger" value="Yes"/>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function deleteModel(model_id){
    $("#form-delete").attr("action", `models/${model_id}`);
  }
</script>

@stop