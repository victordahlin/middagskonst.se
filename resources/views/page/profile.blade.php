@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="h3"><b>Mina sidor</b></div>
  @include('includes.submenu')
  <hr>
  <div class="col-md-12 col-xs-12">
    {!! Form::open(array(
      'url' => '/mina-sidor/'.Request::segment(2),
      'id' => 'RegisterForm',
      'class' => 'form-horizontal'))
      !!}
      @if(empty($data['isActive']))
      <br/>
      <div class="alert alert-warning">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Du har för tillfället pausat din prenumeration. Du kan enkelt starta upp din prenumeration vid önskat tillfälle under fliken kommande leveranser.
      </div>
      @endif

      @if (Request::is('mina-sidor'))
      @include('profile.bags')
      @elseif (Request::is('mina-sidor/alternativa-pasar'))
      @include('profile.alternative-bag')
      @elseif (Request::is('mina-sidor/leveransaddress'))
      @include('profile.deliveryAddress')
      @elseif (Request::is('mina-sidor/kommande-leveranser'))
      @include('profile.delivery')
      @elseif (Request::is('mina-sidor/kvitton'))
      @include('profile.receipt')
      @endif
    </div>
  </div>
  @stop
