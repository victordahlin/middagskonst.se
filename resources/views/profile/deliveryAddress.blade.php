<div class="row">
  <div class="col-md-12 col-xs-12">
    <p>
      Här finns era kontaktuppgifter som ni kan redigera genom att trycka på valfritt fält och skriva in era nya
      uppgifer.<br/>
      När ni väl har tryckt på knappen "Spara inställningar" kommer era uppgifter att ändras.
    </p><br>
    <div class="form-group">
      <label for="inputName" class="control-label col-md-2">Namn</label>
      <div class="col-md-8">
        <input type="text" name="name" class="form-control" id="inputName" placeholder="{{ $data['name'] }}" disabled>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="control-label col-md-2">E-post</label>
      <div class="col-md-8">
        <input type="email" name="email" class="form-control" id="inputEmail" value="{{ $data['email'] }}">
      </div>
    </div>
    <div class="form-group">
      <label for="inputAdress" class="control-label col-md-2">Gatuadress</label>
      <div class="col-md-8">
        <input type="text" name="street" class="form-control" id="inputAdress" value="{{ $data['street'] }}">
      </div>
    </div>
    <div class="form-group">
      <label for="inputAdress" class="control-label col-md-2">Postnummer</label>
      <div class="col-md-8">
        <input type="text" name="postalCode" class="form-control" id="inputAdress" value="{{ $data['postalCode'] }}">
      </div>
    </div>
    <div class="form-group">
      <label for="inputStreet" class="control-label col-md-2">Ort</label>
      <div class="col-md-8">
        <input type="text" name="city" class="form-control" id="inputStreet" value="{{ $data['city'] }}">
      </div>
    </div>
    <div class="form-group">
      <label for="inputTelephone" class="control-label col-md-2">Mobiltelefon</label>
      <div class="col-md-8">
        <input type="text" class="form-control" name="telephoneNumber" id="inputTelephone" value="{{ $data['telephoneNumber'] }}">
      </div>
      <input type="hidden" name="delivery" value="true"/>
    </div>
  </div>
  <br/>
</div><br>
<div class="row">
  <div class="col-xs-12">
    {!! Form::submit('Spara inställningar', array('class' => 'btn btn-success btn-lg green-button')) !!}
    {!! Form::close() !!}
    <br/>
    <br/>
  </div>
</div>
