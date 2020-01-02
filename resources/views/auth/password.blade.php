@extends('layouts.default')
@section('content')
    <div class="container-fluid">
        <div class="col-md-12 col-xs-12">
            <div class="h3">
                <b>Återställ lösenord</b>
            </div>
            <hr>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @elseif (!empty(session('status')))
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="form-group">
                        <b>{!! Form::label('email', 'E-post', array('class' => 'col-md-2 col-xs-12')) !!}</b>

                        <div class="col-md-6 col-xs-12">
                            {!! Form::text('email', Input::old('email'), array(
                            'placeholder' => 'E-post',
                            'size' => '30',
                            'class' => 'form-control'));
                            !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <p class="form-group">
                        {!! Form::submit('Skicka länk', array(
                        'class' => 'btn btn-success green-button',
                        'style' => 'margin-left:10px;',
                        'value' => 'Send Reminder'));
                        !!}
                    </p><br>
                </div>
            </form>
        </div>
    </div>
@stop