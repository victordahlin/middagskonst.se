@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="col-md-12 col-xs-12">
    <div class="h3"><b>Tilläggsprodukter</b></div>
    <hr>
    @if ($errors->has())
    <div class="alert alert-danger">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      @foreach ($errors->all() as $error)
      {{ $error }}
      @endforeach
    </div><br>
    @elseif(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
    </div><br>
    @endif
    <div class="info"></div>
    <div class="alert alert-warning">
      Köper du tilläggsprodukter innan Tisdag kl. 21.00 levereras dessa tillsammans med torsdagens
      leverans av Middagspåsen.
    </div>
    <br>
    <div class="row">
      <div class="col-md-4 col-xs-12">
        {!! Html::image($dinnerProduct->img, '', ['class' => 'img-responsive', 'width' => '125px']) !!}
      </div>
      <div class="col-md-4 col-xs-12"><br>
        <b>{{ $dinnerProduct->title }}</b><br>
        <b><p>{{ $dinnerProduct->discount }} kr/per person</p></b>
        {!! $dinnerProduct->addonsText !!}
      </div>
      <div class="col-md-4 col-xs-12 parentDiv">
        {!! Form::open(array(
          'url' => '/tillaggsprodukter/summering',
          'id' => 'checkout',
          'class' => 'form-horizontal'))
          !!}
          <br>
          <p><b>Välj antal produkter:</b></p>
          <center>
            <input type="text" name="currentBagAmount" value="0" id="{{ $dinnerProduct->discount }}" class="col-lg-3 col-md-3 col-xs-3 extraValue">
          </center>
          <div class="col-xs-6">
            <button type="button" class="btn btn-default add" aria-label="Left Align" value="plus">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-default add" aria-label="Right Align" value="minus">
              <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            </button>
          </div>
        </div>
        <input type="hidden" name="currentBag" value="{{ $dinnerProduct->id }}"/>
      </div>
      <br/>
      <!--
      @foreach($extraProducts as $extra)
      <div class="row">
        <div class="col-md-4 col-xs-12">
          {!! Html::image($extra->img, '', ['class' => 'img-responsive', 'width' =>'125px']) !!}
        </div>
        <div class="col-md-4 col-xs-12"><br>
          <b>{{ $extra->title }}  {{ $extra->price }} kr</b><br>
          {{ $extra->longText }}
        </div>
        <div class="col-md-4 col-xs-12 parentDiv">
          {!! Form::open(array(
            'url' => '/tillaggsprodukter/summering',
            'id' => 'checkout',
            'class' => 'form-horizontal'))
            !!}
            <br>

            <p><b>Välj antal produkter:</b></p>
            <center>
              <input type="text" name="extra[]" value="0" id="{{ $extra->price }}"
              class="col-lg-3 col-md-3 col-xs-3 extraValue">
            </center>
            <div class="col-xs-6">
              <button type="button" class="btn btn-default add" aria-label="Left Align" value="plus">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </button>
              <button type="button" class="btn btn-default add" aria-label="Right Align" value="minus">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div><br>
        @endforeach
      -->
        <div class="row">
          <div class="col-md-4 col-xs-12">
            <div class="h3">
              Totalt <b><span id="extraProductPrice">0</span> kr</b>
              <input type="hidden" name="extraProductPriceInput" id="extraProductPriceInput"/>
            </b><br/>
          </div>
          <br/>
          {!! Form::submit('Till betalning', array('class' => 'btn btn-success btn-lg order-extra
          green-button')) !!}
          {!! Form::close() !!}
        </div>
      </div>
      <br/><br/>
    </div>
  </div>
  @stop
