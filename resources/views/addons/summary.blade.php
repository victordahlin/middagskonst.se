@extends('layouts.default')
@section('content')
    {!! Form::open(array(
        'url' => '/tillaggsprodukter/betala',
        'id' => 'checkout',
        'class' => 'form-horizontal'))
    !!}
    <input type="hidden" name="extraProductPriceInput" value="{{ $data['extraProductPriceInput'] }}">
    <input type="hidden" name="currentBagAmount" value="{{ $data['currentBagAmount'] }}">
    <input type="hidden" name="currentBagID" value="{{ $dinnerProductDB->id }}">
    <input type="hidden" name="extra[]" value="{{ $data['extra'][0] }}">
    <input type="hidden" name="extra[]" value="{{ $data['extra'][1] }}">
    <input type="hidden" name="extra[]" value="{{ $data['extra'][2] }}">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-10 col-md-9">
                <div class="h3"><b>Summering av tilläggsprodukter</b></div><br/>
                <table class="table">
                    <tbody>
                    @for($i = 0; $i < sizeof($extraProductsDB); $i++)
                        <tr>
                            <td class="col-xs-4"><b>{{$extraProductsDB[$i]->title}}</b></td>
                            <td> {{$data['extra'][$i]}} st</td>
                        </tr>
                    @endfor
                    <tr>
                        <td class="col-xs-4"><b>{{$dinnerProductDB->title}}</b></td>
                        <td> {{$data['currentBagAmount']}} st</td>
                    </tr>
                    <tr>
                        <td class="col-xs-4"><b>Att betala</b></td>
                        <td><b>{{$data['extraProductPriceInput']}}</b> kr</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-warning">
                    När ni godkänner betalningen debiteras ert registrerade kort.  Köper du tilläggsprodukter före Tisdag kl. 21.00 levereras dessa tillsammans med torsdagens leverans av Middagspåsen.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-7 col-md-3">
                <a href="{{ url('/tillaggsprodukter') }}" class="btn btn-danger btn-lg">Gå tillbaka</a>
            </div>
            <div class="col-xs-4 col-md-6">
                {!! Form::submit('Betala', array('class' => 'btn btn-success btn-lg order-extra green-button')) !!}
            </div>
        </div>
        <br/><br/>
    </div>
    {!! Form::close(); !!}
@stop


