<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="sv-SE" style="margin: 0;">
<meta charset="utf-8">
<head>
    @include('includes.head')
</head>
<body style="margin: 0;background: url('{{ asset('img/backgrund_web.jpg') }}') no-repeat fixed center center / cover transparent;">
<div id="" class="container" style="background-color:white;">
    <div class="row">
        <div class="col-md-8 col-xs-12 pull-left">
            <div style="margin-left:20px;margin-top:20px;">
                <a href="{{ url('') }}">{!! Html::image('img/MK_Web.png', '',['width' => '8%']) !!}</a>
            </div>
        </div>
        <div class="col-md-2 col-xs-12 pull-right" id="login">
            @if(Auth::check())
                <a href="{{ url('logga-ut') }}" class="btn btn-success green-button">Logga ut</a>
            @else
                <a href="{{ url('/logga-in') }}" class="btn btn-success green-button">Logga in</a>
            @endif
        </div>
    </div>
    <br/>
    @include('includes.header')
    <hr/>
    @yield('content')
</div>
@include('includes.footer')
</body>
</html>