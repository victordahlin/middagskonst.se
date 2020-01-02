<div class="row">
  <div class="col-md-12 col-xs-12">
    <p>
      Önskar du byta ut enbart nästa veckas Middagspåse kan du välja bland våra alternativ nedan.
    </p><br/>
    <p>
      <i>
        Du kan göra dina ändringar från onsdag tom söndag 21.00. Därefter går din beställningen iväg. Men du kan fortfarande köpa till extra påsar eller välja några av våra
        tilläggsprodukter.
      </i>
    </p>
    <br/>
    <hr/>
    <a data-toggle="collapse" href="#melanders" aria-expanded="false" aria-controls="collapseExample">
      {!! Html::image('img/melanders.png', '',
      ['width' => '206px',
      'height' => '59px',
      'border' => '0',
      'alt' => 'Melanders'
      ]) !!}
      <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
    </a>
    <hr>
    <div class="collapse" id="melanders">
      @foreach($alternativeBags as $alternative)
      @if(strpos($alternative->title,'Melanders')!==false)
      <div class="row">
        <div class="col-md-7 col-xs-12">
          <div class="trigger-button">
            <label class="checkbox">
              &nbsp&nbsp
              <input type="radio" name="dinnerProductAlternative" value="{{ $alternative->id }}" @if($data['dinnerProductAlternative'] === "$alternative->id") checked @endif>
              &nbsp&nbsp
              {{ $alternative->title }}
            </label>
          </div>
          <div class="col-xs-12">
            <div class="note light">
              <p>{!! $alternative->longText !!}</p>
            </div>
          </div>
        </div>
        <div class="col-md-5 col-xs-12">
          {!! Html::image($alternative->img, '',
          ['class' => 'img-responsive', 'width' => '50%'])
          !!}
        </div>
      </div>
      @endif
      @endforeach
      <br/>
    </div>
    <a data-toggle="collapse" href="#ulla" aria-expanded="false" aria-controls="collapseExample">
      {!! Html::image('img/ulla_winbladh.jpg', '',[
      'width' => '206px',
      'height' => '59px',
      'border' => '0',
      'alt' => 'Ulla Winbladh']) !!}
      <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
    </a>
    <hr>
    <div class="collapse" id="ulla">
      @foreach($alternativeBags as $alternative)
      @if(strpos($alternative->title,'Winbladhs')!==false)
      <div class="row">
        <div class="col-md-7 col-xs-12">
          <div class="trigger-button">
            <label class="checkbox">
              &nbsp&nbsp
              <input type="radio" name="dinnerProductAlternative" value="{{ $alternative->id }}" @if($data['dinnerProductAlternative'] == "$alternative->id-3") checked @endif>
              &nbsp&nbsp
              {{ $alternative->title }}
            </label>
          </div>
          <div class="col-xs-12">
            <div class="note light">
              <p>{!! $alternative->longText !!}</p>
            </div>
          </div>
        </div>
        <div class="col-md-5 col-xs-12">
          {!! Html::image($alternative->img, '',
          ['class' => 'img-responsive', 'width' => '50%'])
          !!}
        </div>
      </div>
      @endif
      @endforeach
    </div>
    <a data-toggle="collapse" href="#saluhall" aria-expanded="false" aria-controls="collapseExample">
      {!! Html::image('img/lidingosaluhall.png', '',
      ['width' => '225px',
      'height' => '226px',
      'border' => '0',
      'class' => '',
      'style' => 'width:15%;height:auto;',
      'alt' => 'Lindingösaluhall']) !!}
      <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
    </a>
    <hr>
    <div class="collapse" id="saluhall">
      @foreach($alternativeBags as $alternative)
      @if(strpos($alternative->title,'Lidingö saluhalls')!==false)
      <div class="row">
        <div class="col-md-7 col-xs-12">
          <div class="trigger-button">
            <label class="checkbox">
              &nbsp&nbsp
              <input type="radio" name="dinnerProductAlternative" value="{{ $alternative->id }}" @if($data['dinnerProductAlternative'] == "$alternative->id-3") checked @endif>
              &nbsp&nbsp
              {{ $alternative->title }}
            </label>
          </div>
          <div class="col-xs-12">
            <div class="note light">
              <p>{!! $alternative->longText !!}</p>
            </div>
          </div>
        </div>
        <div class="col-md-5 col-xs-12">
          {!! Html::image($alternative->img, '',
          ['class' => 'img-responsive', 'width' => '50%'])
          !!}
        </div>
      </div>
      @endif
      @endforeach
    </div>
    <div class="row">
      <div class="col-xs-12">
        <label class="checkbox">
          &nbsp&nbsp
          <input type="radio" name="dinnerProductAlternative" value="0" @if($data['dinnerProductAlternative'] === "0") checked @endif>
          &nbsp&nbsp
          Ingen alternativ påse
        </label>
      </div>
    </div>
    <hr>
    {!! Form::submit('Spara inställningar', array('class' => 'btn btn-success btn-lg green-button')) !!}
    {!! Form::close() !!}
  </div>
</div>
<br>
<br>
