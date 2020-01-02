@extends('layouts.default')
@section('content')
<div class="col-md-12 col-xs-12">
  <div class="h3"><b>Veckomenyer</b></div>
  <hr>
  @for($i = 0; $i < 6; $i+=2)
  <div class="row">
    <div class="col-lg-12">
      <div class="h4">Vecka {{ $menus[$i]->week }}</div>
    </div>
    <br>
    <div class="col-md-7 col-xs-12">
      @foreach($menus as $menu)
      @if($menu->week == $menus[$i]->week)
      <div class="trigger-button">
        <span>{{ $menu->title }}</span>
      </div>
      @if($menu->title == 'Melanders Fredagspåse')
      <div class="accordion">
        <div class="note light">
          <p><b>Förrätt: </b>{{ $menu->starter }}</p>
          <p><b>Varmrätt: </b>{{ $menu->main }}</p>
          <p><b>Dessert: </b>{{ $menu->dessert }}</p>
        </div>
      </div>
      @else
      <div class="accordion">
        <div class="note light">
          <p>{{ $menu->text }}</p>
        </div>
      </div>
      @endif
      @endif
      @endforeach
    </div>
    <div class="col-md-5 col-xs-12">
      <div>
        <center>
          {!! Html::image('img/fredagspåse_web.jpg', '', ['class' => 'img-responsive', 'width' => '50%']) !!}
        </center>
      </div>
      <p></p>

      <div class='divider' style='height: 20px;'></div>
      <div class='clear'></div>
    </div>
  </div>
  @endfor
</div>
@stop
