<div class="row">
  <div class="col-md-12 col-xs-12">
    <p>
      Här kan ni ändra frekvensen på leveranser varje vecka eller pausa din prenumeration.<br />
      <i>För övriga frågor kontakta <a href="mailto:info@middagskonst.se">info@middagskonst.se</a></i>
    </p><br>
    <table class="table table-striped">
      <tbody>
        <tr>
          <td>
            <input type="radio" class="col-sm-8" name="subscription" value="off" @if($data['interval']=='off' ) checked @endif>
          </td>
          <td class="col-md-10"><b>Pausa din prenumeration</b></td>
          <td></td>
        </tr>
        <tr>
          <td><input type="radio" class="col-sm-8" name="subscription" value="eachWeek" @if($data['interval']=='eachWeek' ) checked @endif></td>
          <td class="col-md-10"><b>Varje vecka</b></td>
          <td></td>
        </tr>
        <tr>
          <td><input type="radio" class="col-sm-8" name="subscription" value="everySecondWeek" @if($data['interval']=='everySecondWeek' ) checked @endif></td>
          <td class="col-md-10"><b>Varannan vecka</b></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="alert alert-warning" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span>Avbokning av veckans leverans måste ske före söndag kl 21:00</span>
    </div>
    <br>
    <p>
      Ska ni resa bort? Då kan ni enkelt pausa specifika veckor genom att bocka ur de nedstående alternativ ni ej önskar leverans.
    </p>
    <p>
      <i>Om det valda alternativet är grå markerat innebär det att produkten har gått iväg för beställning.</i>
    </p>
    <br />
    @if(date("W")>=25&&date("W")<32) <p>
      <i>Mellan vecka 25 och 32 har Melanders och Middagskonst sommaruppehåll men ni kan fortfarande se när nästa leverans sker.</i>
      </p><br />
      @endif
      @if (!$errors->isEmpty())
      <div class="alert alert-danger">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
      </div>
      @endif
      <table class="table table-responsive">
        <tbody>
          @for ($i = 0; $i < 5; $i++) @if($data['fiveWeeks'][$i]>= $data['startDate'] )
            <tr class="dateTR{{ $i }}">
              <td class="col-md-3"><b>v.{{ $data['weekNumbers'][$i] }}</b></td>
              <td class="col-md-3"><b class="date{{ $i }}">{{ $data['fiveWeeks'][$i] }}</b></td>
              <td class="col-md-3"></td>
              <input id="weeksHidden" name="weeks[]" type="hidden" value="{{ $data['fiveWeeks'][$i] }}">
            </tr>
            @endif
            @endfor
            <input type="hidden" class="displayPHPerrors" name="displayPHPerror" value="true" />
        </tbody>
      </table>
      {!! Form::submit('Spara inställningar', array('class' => 'btn btn-success btn-lg green-button')) !!}
      {!! Form::close() !!}
      <br />
      <br />
  </div>
</div>