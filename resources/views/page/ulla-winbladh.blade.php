@extends('layouts.default')
@section('content')

<div class="container-fluid">
  <div class="col-md-12 col-xs-12">
    {!! Html::image('img/ulla_winbladh.jpg', '',[
    'width' => '206px',
    'height' => '59px',
    'border' => '0',
    'alt' => 'Ulla Winbladh']) !!}
    <div class="row">
      <div class="products">
        <div class="col-xs-12">
          <br>
          <p>
            {!! $dinnerBags[1]->text !!}
          </p>
          <br>
          <br>
        </div>
        @for($i = 0; $i < sizeof($products); $i++) @if(strpos($products[$i]->title,'Winbladhs')!==false)
          <a href="javascript:void(0)" class="menu">
            {!! Form::hidden('',$i,'') !!}
            <div class="col-xs-12 col-sm-5 col-sm-offset-3" id="stora-matkassen">
              <div class="col-xs-12 product">
                <!-- product -->
                <header class="row visible-sm">
                  <div class="h2">
                    <center>
                      {{ $products[$i]->title }}
                    </center>
                  </div>
                </header>
                <div class="row cont">
                  <div class="col-xs-12 col-sm-4">
                    {!! Html::image($products[$i]->img, '', array(
                    'class' => 'img-responsive',
                    'title' => $products[$i]->title . ' - ' . $products[$i]->text,
                    'style' => 'padding-top:25px;margin-left:5px' ))
                    !!}
                  </div>
                  <div class="col-xs-12 col-sm-8">
                    <header class="row hidden-sm text-center">
                      <div class="h3"><b>{{ $products[$i]->title }}</b></div>
                    </header>
                    <div class="row text-center">
                      <span class="col-xs-12 bag-short"><b>{{ $products[$i]->text }}</b></span>
                      <span class="col-xs-12">Pris per leverans</span>
                      <div class="col-xs-10 col-xs-push-1">
                        <span>
                          <b>{{ $products[$i]->price }} KR</b>
                          <br /><i>inkl frakt</i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-xs-12 bag-desc">
                    {!! $products[$i]->longText !!}
                  </div>
                </div>
                <div class="row">
                  <div class="button-container text-center">
                    <div class="h3"><b>Bli kund</b></div>
                  </div>
                </div>
                <br>
              </div>
              <!-- /product -->
            </div>
          </a>
          @endif
          @endfor
          <div class="col-xs-12">
            <div class="h3"><b>Veckomenyer</b></div>
            <hr>
            <div class="row">
              <div class="col-md-12 col-xs-12">
                @foreach($menus as $menu)
                <br>
                <div class="trigger-button">
                  <span>Vecka {{ $menu->week }}</span>
                </div>
                <div class="accordion">
                  <div class="note light">
                    <p><b>Förrätt: </b>{{ $menu->starter }}</p>
                    <p><b>Varmrätt: </b>{{ $menu->main }}</p>
                    <p><b>Dessert: </b>{{ $menu->dessert }}</p>
                  </div>
                </div>
                <div class="accordion">
                  <div class="note light">
                    <p>{{ $menu->text }}</p>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <br><br><br>
          </div>
      </div>
      <!-- /products -->
    </div>
  </div>
</div>
@stop