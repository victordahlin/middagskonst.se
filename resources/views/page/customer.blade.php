@extends('layouts.default')
@section('content')
<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="h3"><b>Bli kund</b></div>
  </div>
  <hr>
  {!! Form::open(array(
    'url' => 'bli-kund/betala',
    'id' => 'checkout',
    'class' => 'form-horizontal'))
    !!}
    <div class="col-md-6 col-xs-12">
      <div class="h4">
        <b>1. Välj första leverans</b>
      </div>
      <p>Nedan kan du välja det datum då du vill påbörja din prenumeration</p>
      @for($i = 0; $i < 5; $i++)
      <div class="radio">
        <label for="">
          <input type="radio" name="firstDelivery" value="{{ $data['fiveWeeks'][$i] }}" @if($i == 0) checked @endif><b>{{ $data['fiveWeeks'][$i] }}</b>
        </label>
      </div>
      @endfor
      <br/>
    </div>
    <div class="col-md-6 col-xs-12">
      <div class="h4">
        <b>Din beställning</b>
      </div>
      <div class="col-md-3">
        {!! Html::image($data['dinnerProduct']->img, 'Titel', array('width' => '150px')) !!}
      </div>
      <div class="row">
        <div class="col-md-5 col-xs-12">
          <div class="h4">
            {{ $data['dinnerProduct']->summaryText }}
          </div>
        </div>
      </div>
      <div class="h4">
        Totalsumma <b><span id="sum"> {{ $data['dinnerProductPrice'] }} kr</span><br/></b>
      </div><br/>
      <input type="hidden" value="{{ $data['dinnerProduct']->id }}" name="dinnerProduct">
      <input type="hidden" value="{{ $data['dinnerProductPrice'] }}" name="dinnerProductPrice">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-xs-12">
      <div class="h4">
        <b>2. Hur ofta vill du ha leverans?</b>
      </div>
      <p>
        Här kan du välja hur ofta du önskar få din Middagspåse levererad. Självklart kan du alltid pausa prenumerationen när du vill
      </p>
      <div class="radio">
        <label for="">
          <input type="radio" name="interval" value="eachWeek" checked><b> Varje vecka</b>
        </label>
      </div>
      <div class="radio">
        <label for="">
          <input type="radio" name="interval" value="everySecondWeek"><b> Varannan vecka</b>
        </label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-xs-12">
      @if ($errors->has())
      @foreach ($errors->all() as $error)
      <div class="alert alert-danger">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {{ $error }}<br>
      </div>
      @endforeach
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="h4">
        <b>3. Kontaktuppgifter</b>
      </div>
      <p>
        Alla fält med * måste fyllas i för att du ska kunna slutföra din beställning.<br/>
      </p><br/>
      <div class="form-group">
        <label for="firstName" class="control-label col-md-2"><b>Förnamn *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="firstName" class="form-control" value="{{ Input::old('firstName') }}" placeholder="Förnamn">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="lastName" class="control-label col-md-2"><b>Efternamn *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="lastName" class="form-control" value="{{ Input::old('lastName') }}" placeholder="Efternamn">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="telephoneNumber" class="control-label col-md-2"><b>Mobiltelefon *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="telephoneNumber" class="form-control" value="{{ Input::old('telephoneNumber') }}" placeholder="Mobiltelefon">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="email" class="control-label col-md-2"><b>E-post *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="email" class="form-control" value="{{ Input::old('email') }}" placeholder="E-post">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="emailConfirm" class="control-label col-md-2"><b>E-post *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="emailConfirm" class="form-control" value="{{ Input::old('emailConfirm') }}" placeholder="Bekräfta e-post">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="password" class="control-label col-md-2"><b>Lösenord *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="password" name="password" class="form-control" value="{{ Input::old('password') }}" placeholder="Lösenordet måste vara minst 5 tecken långt">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="passwordConfirm" class="control-label col-md-2"><b>Lösenord *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="password" name="passwordConfirm" class="form-control" value="{{ Input::old('passwordConfirm') }}" placeholder="Lösenordet måste vara minst 5 tecken långt">
        </div>
      </div>
    </div>
  </div><br/>
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="h4">
        <b>4. Leveransuppgifter</b>
      </div>
      <p>
        Alla fält med * måste fyllas i för att du ska kunna slutföra din beställning.
      </p><br/>
      <div class="form-group">
        <label for="street" class="control-label col-md-2"><b>Gatuadress *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="street" class="form-control" value="{{ Input::old('street') }}" placeholder="Gatuadress">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="postalCode" class="control-label col-md-2"><b>Postnummer *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="postalCode" class="form-control" value="{{ Input::old('postalCode') }}" placeholder="Postnummer">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="city" class="control-label col-md-2"><b>Ort *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="city" class="form-control" value="{{ Input::old('city') }}" placeholder="Ort">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="doorCode" class="control-label col-md-2"><b>Portkod</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="doorCode" class="form-control" value="{{ Input::old('doorCode') }}" placeholder="Portkod">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="additionalInfo" class="control-label col-md-2"><b>Övrigt</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="additionalInfo" class="form-control" value="{{ Input::old('additionalInfo') }}" placeholder="Lägenhet till vänster, tre trappor..">
        </div>
      </div><br/>
      <div class="form-group">
        <label for="telephoneNumberDriver" class="control-label col-md-2"><b>Mobiltelefon *</b></label>
        <div class="col-md-8 col-xs-12">
          <input type="text" name="telephoneNumberDriver" class="form-control" value="{{ Input::old('telephoneNumberDriver') }}" placeholder="Mobiltelefon för leverans">
        </div>
      </div>
    </div>
  </div><br/>
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="h4">
        <b>5. Betalning via PayEx</b>
      </div>
      <div style="font-size:13px;">
        <p>
          <b>
            När du registrerar dig som kortkund dras 2 kronor från ditt kort för att kontrollera att det fungerar. Som kompensation får du en välkomstgåva vid din första leverans. Ditt registrerade kort debiteras för Middagspåsen söndagen innan din första leverans
          </b>
        </p><br/>
        <i>
          <p>
            Kortbetalning genomförs via PayEx, som erbjuder trygg och enkel kortbetalning. Ni kommer nu bli skickad till PayEx för att fylla era kortuppgifter och slutföra din registrering.
          </p><br/>
          <p>
            För övriga frågor eller några eventuella problem, tryck på bilden för att komma till PayEx.
          </p><br/>
        </i>
      </div>

      <a href="{{ url('http://payex.se/privat/om-payex/kontakt') }}" target="_blank">
        {!! Html::image('img/payex.png', 'a picture', array('class' => 'img-responsive')) !!}
      </a><br/>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="confirmAgreement" value="true">Jag accepterar <span style="color:#3E8F3E" data-toggle="collapse" data-target="#toggle">villkoren</span> för middagskonst
        </label>
        <p class="error"></p>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-12 collapse" id="toggle">
          <div >
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
        </div>
      </div>
      <div class="row">
        <input type="hidden" name="dinnerProductPrice" value="{{ $data['dinnerProductPrice'] }}" id="totalsum" class="col-md-6 col-xs-12">
      </div>
      <br>
      <div class="row">
        <div class="col-xs-12">
          {!! Form::submit('Till betalningen', [
          'class' => 'btn btn-success btn-lg confirm green-button',
          'id' => '',
          'style' => 'margin-left:15px;'])!!}
          {!! Form::close() !!}
        </div>
      </div>
      <br><br>
    </div>
  </div>
  @stop
