@extends('layouts.default')
@section('content')

<div class="container-fluid">
  <div class="col-md-9 col-xs-10">
    <div class="h3"><b>Tack för din beställning!</b></div>
    <hr>
  </div><br>
  <div class="col-xs-12 col-md-8">
    <div class="alert alert-success" role="alert">
      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
      Registreringen är nu genomförd.<br/>
      Din första debitering kommer att ske söndag den {{ $data['billingDate'] }}<br/>
      Dina kvitton hittar du i undermenyn på mina sidor.<br/>
    </div>
    <p>
      Du kommer inom kort att få ett välkomstmail där du finner matnyttig information om tjänsten. Du kan enkelt logga in på Mina sidor för att göra ändringar eller köpa till extra produkter
    </p><br/>
    <p>
      <i>
        Har du inte fått ditt välkomstmail inom 24 timmar, var vänlig kontakta oss på <a href="mailto:info@middagskonst.se">info@middagskonst.se</a>
      </i>
    </p><br/>
  </div>
  <div class="col-xs-10 col-md-9">
    <div class="h4"><b>Summering</b></div>
    <table class="table">
      <tbody>
        <tr>
          <td class="col-xs-4"><b>Namn</b></td>
          <td>{{ $data['name'] }}</td>
        </tr>
        <tr>
          <td class="col-xs-4"><b>Address</b></td>
          <td>{{ $data['street'] }}, {{ $data['postalCode'] }}, {{ $data['city'] }}</td>
        </tr>
        <tr>
          <td class="col-xs-4"><b>Telefon</b></td>
          <td>{{ $data['telephoneNumber'] }}</td>
        </tr>
        <tr>
          <td class="col-xs-4"><b>E-post</b></td>
          <td>{{ $data['email'] }}</td>
        </tr>
        <tr>
          <td class="col-xs-4"><b>Första leverans sker</b></td>
          <td>{{ $data['startDate'] }}</td>
        </tr>
        <tr>
          <td class="col-xs-3"><b>Ordernummer</b></td>
          <td>{{ $data['orderNumber'] }}</td>
        </tr>
        <tr>
          <td class="col-xs-3"><b>Totalt inkl moms</b></td>
          <td>{{ $data['total'] }} kr</td>
        </tr>
      </tbody>
    </table>
  </div>
  <br/>
</div>
@stop
