@extends('layouts.default')
@section('content')
    {!! Form::open(array(
    'url' => 'logga-in',
    'id' => 'checkout'))
    !!}
    <div class="container-fluid">
        <div class="col-md-12 col-xs-12">
            <div class="h3">
                <b>Logga in</b>
            </div>
            <hr>
            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        {{ $error }}<br>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="form-group">
                    <b>{!! Form::label('email', 'E-post', array('class' => 'col-md-2 col-xs-12')) !!}</b>
                    <div class="col-md-6 col-xs-12">
                        {!! Form::text('email', Input::old('email'), array(
                        'placeholder' => 'E-post',
                        'size' => '30',
                        'class' => 'form-control'))
                        !!}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="form-group">
                    <b>{!! Form::label('password', 'Lösenord', array('class' => 'col-md-2 col-xs-12')) !!}</b>
                    <div class="col-md-6 col-xs-12">
                        {!! Form::password('password', array(
                        'placeholder' => 'Lösenord',
                        'size' => '30',
                        'class' => 'form-control'))
                        !!}
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <p>Du kan återställa ditt lösenord <a class="link" href="{{ url('/password/email') }}">här</a></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <p class="form-group AddressForm">
                    {!! Form::submit('Logga in', array(
                    'class' => 'btn btn-success green-button',
                    'style' => 'margin-left:10px;'))
                    !!}
                </p><br>
            </div>
            <br>
        </div>
    </div>
    {!! Form::close() !!}
@stop

