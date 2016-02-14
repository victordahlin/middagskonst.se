@extends('layouts.default')
@section('content')
<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="h3"><b>Kontrollpanel</b></div>
    <hr>
    {!! Form::open(array(
      'url' => 'dashboard',
      'class' => 'form-horizontal'));
      !!}
      @for($i = 0; $i < sizeof($dinnerMenu); $i+=2)
      @foreach($dinnerMenu as $menu)
      @if($menu->week == $dinnerMenu[$i]->week)
      @if(!empty($menu->starter))
      <div class="form-group">
        <label for="inputName" class="control-label col-md-2">Huvudrätt: </label>
        <div class="col-md-9 col-xs-12">
          <input type="text" name="starter{{ $menu->id }}" class="form-control" id="inputStarter" value="{{ $menu->starter }}">
        </div>
      </div>
      <div class="form-group">
        <label for="inputName" class="control-label col-md-2">Varmrätt: </label>
        <div class="col-md-9 col-xs-12">
          <input type="text" name="main{{ $menu->id }}" class="form-control" id="inputStarter" value="{{ $menu->main }}">
        </div>
      </div>
      <div class="form-group">
        <label for="inputName" class="control-label col-md-2">Dessert: </label>
        <div class="col-md-9 col-xs-12">
          <input type="text" name="dessert{{ $menu->id }}" class="form-control" id="inputDessert" value="{{ $menu->dessert }}">
        </div>
      </div>
      <div class="form-group">
        <label for="inputName" class="control-label col-md-2">Vecka: </label>
        <div class="col-md-9 col-xs-12">
          <input type="text" name="week{{ $menu->id }}" class="form-control" id="inputWeek" value="{{ $menu->week }}">
        </div>
      </div>
      @endif
      @endif
      <div style="margin: 50px 0;"></div>
      @endforeach
      @endfor
      {!! Form::submit('Spara menyer', [
      'class' => 'btn btn-success btn-lg confirm green-button'])!!}
      {!! Form::close(); !!}
    </div>
  </div>
  <br/><br/><br/>
  @stop
