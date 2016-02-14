<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-submenu" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar-submenu" class="navbar-collapse collapse">
      <ul class="nav navbar-nav" id="nav">
        <li class="{{ Request::segment(1) === 'mina-sidor' && empty(Request::segment(2)) ? 'active' : '' }}" role="presentation">
          <a href="{{ url('/mina-sidor') }}">Veckans påse</a>
        </li>
        <li class="{{ Request::segment(2) === 'alternativa-pasar' ? 'active':'' }}" role="presentation">
          <a href="{{ url('/mina-sidor/alternativa-pasar') }}">Alternativa påsar</a>
        </li>
        <li class="{{ Request::segment(2) === 'leveransaddress' ? 'active':'' }}" role="presentation">
          <a href="{{ url('/mina-sidor/leveransaddress') }}">Leveransadress</a>
        </li>
        <li class="{{ Request::segment(2) === 'kommande-leveranser' ? 'active':'' }}" role="presentation">
          <a href="{{ url('/mina-sidor/kommande-leveranser') }}">Kommande leveranser</a>
        </li>
        <li class="{{ Request::segment(2) === 'kvitton' ? 'active':'' }}" role="presentation">
          <a href="{{ url('/mina-sidor/kvitton') }}">Kvitton</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
