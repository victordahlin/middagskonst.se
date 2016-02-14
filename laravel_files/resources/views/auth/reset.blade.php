@extends('layouts.default')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <br/>

            <div class="col-md-12 col-xs-12">
                <div class="h3">
                    <b>Logga in</b>
                </div>
                <hr>
            </div>
            <div class="col-md-8 col-xs-12">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">E-post address</label>

                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-post address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Lösenord</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" placeholder="Lösenord">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Bekräfta lösenord</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Bekräfta lösenord">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-success green-button">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><br/>
@stop
