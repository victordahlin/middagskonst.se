<div class="row">
  <div class="col-md-12 col-xs-12">
    <p>Här nedanför kan du se kvitton från dina tidigare köp. </p><br>
    <table class="table table-striped">
      <tbody>
        @for($i = 0; $i < sizeof($data['files']); $i++)
        <tr>
          <td><p>{{ $i+1 }}</p></td>
          <td><a href="{{ str_replace('mina-sidor/kvitton','',Request::url()).'invoice/'.$data['id'].'/'.$data['files'][$i] }}" download>{{ $data['files'][$i] }}</a></td>
          <td></td>
        </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div><br>
