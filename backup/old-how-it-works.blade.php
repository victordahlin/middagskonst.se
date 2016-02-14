
    <!--
    <table class="table table-striped">
      <tbody>
        @foreach($data['dinnerProductsDB'] as $dinnerProduct)
        <tr>
          <td>
            <input type="radio" name="dinnerProduct" value="{{ $dinnerProduct->id }}" class="col-md-5" @if($data['dinnerProduct'] == $dinnerProduct->id) checked @endif>
          </td>
          <td class="col-md-3">{{ $dinnerProduct->title }}</td>
          <td><b>{{ $dinnerProduct->price }} kr</b> <i>inkl frakt</i></td>
        </tr>
        @endforeach
        <br>
      </tbody>
    </table>

    <button type="button" class="btn btn-success btn-large green-button" data-toggle="collapse" data-target="#demo">Övriga Middagspåsar</button>
    <div id="demo" class="collapse">
      <br>
      <table class="table table-striped">
        <tbody>
          @foreach($data['dinnerProductsDB'] as $dinnerProduct)
          @if(strpos($dinnerProduct->title,'Melanders')===false)
          <tr>
            <td>
              <input type="radio" name="dinnerProduct" value="{{ $dinnerProduct->id }}" class="col-md-5" @if($data['dinnerProduct'] == $dinnerProduct->id) checked @endif>
            </td>
            <td class="col-md-3">{{ $dinnerProduct->title }}</td>
            <td><b>{{ $dinnerProduct->price }} kr</b> <i>inkl frakt</i></td>
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>
    </div>
  -->
