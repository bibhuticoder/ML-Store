@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<div class="row">
  <div class="col-md-3">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{$models_count}}</h3>
        <p>Models</p>
      </div>
      <div class="icon">
        <i class="fa fa-fw fa-cubes"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-md-3">
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{$updates_count}}</h3>
        <p>Updates</p>
      </div>
      <div class="icon">
        <i class="fa fa-paper-plane"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-md-3">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$reviews_count}}</h3>
        <p>Reviews</p>
      </div>
      <div class="icon">
        <i class="fa fa-comments-o"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-md-3">
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{{$credits}}</h3>
        <p>Credits</p>
      </div>
      <div class="icon">
        <i class="fa fa-money"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
<br>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"> Recent updates </h3>
      </div>
      <div class="box-body">
        <table class="table">
          <thead>
            <th>Sn.</th>
            <th>Model</th>
            <th>Credits</th>
            <th>User</th>
            <th>Updated At</th>
          </thead>
          <tbody>
            @foreach ($updates as $count => $update)
              <tr>
                <td>{{ $count + 1 }}</td>
                <td>{{ $update->model->title }}</td>
                <td>{{ $update->credits_earned }}</td>
                <td>{{ $update->user->username }}</td>
                <td>{{ $update->updated_at->toDateTimeString() }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@stop