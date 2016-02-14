<div class="row">
  <div class="col-md-12 col-xs-12">
    <p>Här finner du din valda Middagspåse från Middagskonst. Önskar du byta din återkommande Middagspåse, gör du det genom att ändra val nedan.</p>
    <br/>
    <p>
      <i>
        Du kan göra dina ändringar från onsdag tom söndag 21.00. Därefter går din beställningen iväg. Men du kan fortfarande köpa till extra påsar eller välja några av våra
        tilläggsprodukter.
      </i>
    </p>
    @if(!empty($data['dinnerProductAlternative']))
    <br/>
    <div class="alert alert-warning">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      Den här veckan har ni valt att byta till en av våra alternativa påsar.
    </div>
    @endif
    <br>
    <select class="form-control" name="dinnerProduct">
      @foreach($data['dinnerProductsDB'] as $dinnerProduct)
      <option value="{{ $dinnerProduct->id }}" @if($data['dinnerProduct'] == $dinnerProduct->id) selected="selected" @endif>{{ $dinnerProduct->title }} {{ $dinnerProduct->price }} kr</b> <i>inkl frakt</i></option>
      @endforeach
    </select>
  </div>

  <div class="row">
    <div class="col-md-12 col-xs-12">
      <br>
      Vill du komplettera din middag eller köpa till extra Middagspåsar? Se våra
      <a href="{{ url('/tillaggsprodukter') }}">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><b> tilläggsprodukter</b>
      </a>
    </div>
  </div>
  {!! Form::submit('Spara inställningar', array('class' => 'btn btn-success btn-lg green-button')) !!}
  {!! Form::close() !!}
  <br/>
  <br/>
</div>
