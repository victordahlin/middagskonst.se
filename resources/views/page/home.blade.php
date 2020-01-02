@extends('layouts.default')
@section('content')

<div class="startpage row">
  <div class="col-md-12 start">
    <div class="text col-xs-12 col-md-6">
      <div class="hero">
        <br>
        <div class="row" style="margin:0;">
          {!! Html::image('img/Middagskonst_Web.png', '',
          ['width' => '720px',
          'height' => '62px',
          'border' => '0',
          'class' => '',
          'style' => 'width:50%;height:auto;',
          'alt' => 'Middagskonst'])
          !!}
        </div>
        <br/>
        @if(date("W")>=25&&date("W")<32)
        <p style="color:#ff0000">
          <i>Mellan vecka 25 och 32 har Middagskonst sommaruppehåll men ni kan fortfarande se när nästa leverans sker.</i>
        </p><br/>
        @endif
        <p>
          <b>{!! $startPageText[0]->title !!}</b>
          <br>
          {!! $startPageText[0]->text !!}
        </p>
        <br>
        <p>
          <b>{!! $startPageText[1]->title !!}</b>
          <br/>
          {!! $startPageText[1]->text !!}
        </p>
        <br/>
      </div>
      <hr>
      <div class="h4">
        <b>Se om vi kan leverera där du bor:</b>
      </div>
      <p style="font-size:13px;"><i>Just nu levererar vi endast till Stockholmsområdet</i></p><br/>
      {!! Form::open(array('url' => 'postal')) !!}
      <div class="form-group ">
        <input type="text" name="postalCode" class="form-control" placeholder="Postnummer">
      </div>
      <button type="submit" class="btn btn-success green-button">Kolla postnumret</button>
      <br>
      {!! Form::close() !!}
      <br>
      <div>
        <div class="alert alert-danger" role="alert" id="danger">
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          Tyvärr kan vi inte ännu leverera till den givna postadressen, men vi utökar ständigt
          våra leveransområden. Kontakta oss så ska vi se om vi kan hitta en lösning för er.
        </div>
        <div class="alert alert-success" role="alert" id="success">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          Vi kan leverera till ert postnummer!
        </div>
      </div>
    </div>
    <div class="image col-xs-6 col-md-6">
      {!! Html::image('img/rom_web.jpg', 'a picture', ['class' => 'img-responsive ', 'width' => '87%']) !!}
    </div>
  </div>
</div>
<div class="products row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br>
    <hr/>
    <div class="h3">
      <b>
        <center>Välj Middagspåse</center>
      </b>
      <hr>
    </div>
    <br/>
    <!-- Lidingö -->
    <div class="col-xs-12 col-sm-6 col-md-4">
      <a href="{{ url('/lidingosaluhall') }}">
        <div class="col-xs-12 col-lg-12 product">
          <header class="product-header row text-center ">
            <div class="h4"><b>{{ str_replace('Kött','',$products[1]->title) }}</b></div>
          </header>
          <section class="product-section start row">
            <div class="product-container">
              <div class="col-xs-5 col-sm-5 col-lg-5 product-image start">
                {!! Html::image('img/lidingosaluhall_alternative.jpg', '', array(
                'class' => 'img-responsive',
                'title' => $products[1]->title,
                'style' => 'padding-top:15px;margin-left:5px;'))
                !!}
              </div>
              <div class="col-xs-7 col-sm-7 col-lg-7 product-description start">
                <div class="camp-text clearfix">
                  <p>{{ $products[1]->summaryText }}</p>
                </div>
                <div class="camp-price clearfix">
                  <span class="camp-price__numbers">
                    {{ $products[1]->price }}
                  </span>
                  <span class="camp-price__currency">
                    kr <br/>
                    <i style="font-size: 11px;">inkl frakt</i>
                  </span>
                </div>
                <div class="read-more-url clearfix">
                  <span><b>Läs mer</b></span>
                </div>
                <br/>
              </div>
            </div>
          </section>
        </div>
      </a>
    </div>
    <!-- Melanders -->
    <div class="col-xs-12 col-sm-6 col-md-4">
      <a href="{{ url('/melanders') }}">
        <div class="col-xs-12 col-lg-12 product">
          <header class="product-header row text-center ">
            <div class="h4"><b>{{ $products[2]->title }}</b></div>
          </header>
          <section class="product-section start row">
            <div class="product-container">
              <div class="col-xs-5 col-sm-5 col-lg-5 product-image start">
                {!! Html::image($products[2]->img, '', array(
                'class' => 'img-responsive',
                'title' => $products[1]->title,
                'style' => 'padding-top:15px;margin-left:5px;'))
                !!}
              </div>
              <div class="col-xs-7 col-sm-7 col-lg-7 product-description start">
                <div class="camp-text clearfix">
                  <p>{{ $products[2]->summaryText }}</p>
                </div>
                <div class="camp-price clearfix">
                  <span class="camp-price__numbers">
                    {{ $products[2]->price }}
                  </span>
                  <span class="camp-price__currency">
                    kr <br/>
                    <i style="font-size: 11px;">inkl frakt</i>
                  </span>
                </div>
                <br>
                <br>
                <div class="read-more-url clearfix">
                  <span><b>Läs mer</b></span>
                </div>
                <br>
              </div>
            </div>
          </section>
        </div>
      </a>
    </div>
    <!-- Ulla winbladhs -->
    <div class="col-xs-12 col-sm-6 col-md-4">
      <a href="{{ url('/ulla-winbladh') }}">
        <div class="col-xs-12 col-lg-12 product">
          <header class="product-header row text-center ">
            <div class="h4">
              <b>{{ $products[4]->title }}</b>
            </div>
          </header>
          <section class="product-section start row">
            <div class="product-container">
              <div class="col-xs-5 col-sm-5 col-lg-5 product-image start">
                {!! Html::image($products[4]->img, '', array(
                'class' => 'img-responsive',
                'title' => $products[4]->title,
                'style' => 'padding-top:15px;margin-left:5px;'))
                !!}
              </div>
              <div class="col-xs-7 col-sm-7 col-lg-7 product-description start">
                <div class="camp-text clearfix">
                  <p>{{ $products[4]->summaryText }}</p>
                </div>
                <div class="camp-price clearfix">
                  <span class="camp-price__numbers">
                    {{ $products[4]->price }}
                  </span>
                  <span class="camp-price__currency">
                    kr <br/>
                    <i style="font-size: 11px;">inkl frakt</i>
                  </span>
                </div>
                <br>
                <br>
                <div class="read-more-url clearfix">
                  <span><b>Läs mer</b></span>
                </div>
                <br>
              </div>
            </div>
          </section>
        </div>
      </a>
    </div>
  </div>
</div>
<hr/>
@stop
