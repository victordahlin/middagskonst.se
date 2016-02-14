@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="col-md-9 col-xs-12">
    <div class="h3">
      <b>Villkor</b>
    </div>
    <hr>
    @for($i = 5; $i < 16; $i++)
    <div class="h4">
      <b>
        {!! $texts[$i]->title !!}
      </b>
    </div>
    <p>
      {!! $texts[$i]->text !!}
    </p>
    <br>
    @endfor
    <hr>

    <br><br>
  </div>
</div>
@stop
