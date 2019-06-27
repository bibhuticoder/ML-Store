@extends('adminlte::page')

@section('title', 'Model Detail')

@section('content')
<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"> Model Details </h3>
  </div>
  <div class="box-body">
  <p class="lead">Title: {{$model->title}}</p>
  <p class="lead">Version: {{$model->version}}</p>
  <p class="lead">Credits per training: Rs.{{$model->credits_per_training}}</p>
  <p class="lead">Total training data required: {{$model->max_training_count}}</p>
  <p class="lead">Update threshold: {{$model->update_threshold}}</p>
  <p class="lead">Created at: {{$model->created_at}}</p>
  <p class="lead">Last updated at: {{$model->updated_at}}</p>
  </div>
</div>

<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"> Reviews </h3>
  </div>
    <table class="table striped">
      <thead>
        <th>Sn</th>
        <th>User</th>
        <th>Rating</th>
        <th>Review</th>
        <th>Date</th>
      </thead>
      <tbody>
        @foreach ($model->reviews as $review)
          <tr>
            <td>{{$review->id}}</td>
            <td>{{$review->user->username}}</td>
            <td>
              @for ($i = 0; $i < $review->rating; $i++)
                <span class="fa fa-star checked"></span>    
              @endfor
            </td>
            <td>{{$review->content}}</td>
            <td>{{$review->created_at}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop