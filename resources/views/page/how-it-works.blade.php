@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="col-md-12 col-xs-12">
    <div class="h3">
      <b>Så funkar det</b>
    </div>
    <hr>
    @for($i = 0; $i < 5; $i++)
    <div class="h4">
      <b>
        {!! $texts[$i]->title !!}
      </b>
    </div>
    <p>
      {!! $texts[$i]->text !!}
      @if($i === 3)
      Se mer under <a id="villkor"><b><i>våra villkor</i></b></a>
      @endif
    </p>
    <br>
    @endfor
    <div style="display:none" id="toggle">
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
    </div>
    <br>
  </div>
</div>
@stop
