<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav" id="nav">
        <li class="{{ Request::segment(1) == '' ? 'active' : '' }}">
          <a href="{{ url('/') }}">Hem</a>
        </li>
        <li class="{{ Request::segment(1) == 'sa-funkar-det' ? 'active' : '' }}">
          <a href="{{ url('/sa-funkar-det') }}">Så funkar det</a>
        </li>
        @if(Auth::check())
        <li class="{{ Request::segment(1) == 'tillaggsprodukter' ? 'active' : '' }}">
          <a href="{{ url('/tillaggsprodukter') }}">Tilläggsprodukter</a>
        </li>
        @else
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Vilken middagspåse <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="{{ Request::segment(1) == 'melanders' || Request::segment(1) === 'bli-kund' ? 'active' : '' }}">
              <a href="{{ url('/melanders') }}">Melanders</a>
            </li>
            <li class="{{ Request::segment(1) == 'ulla-winbladh' || Request::segment(1) === 'bli-kund' ? 'active' : '' }}">
              <a href="{{ url('/ulla-winbladh') }}">Ulla Winbladh</a>
            </li>
            <li class="{{ Request::segment(1) == 'lidingosaluhall' || Request::segment(1) === 'bli-kund' ? 'active' : '' }}">
              <a href="{{ url('/lidingosaluhall') }}">Lidingö saluhall</a>
            </li>
          </ul>
        </li>
        @endif
        <li class="{{ Request::segment(1) == 'om-oss' ? 'active' : '' }}">
          <a href="{{ url('/om-oss') }}">Om oss</a>
        </li>
        <li class="{{ Request::segment(1) == 'mina-sidor' || Request::segment(1) == 'logga-in' ? 'active' : '' }}">
          <a href="{{ url('/mina-sidor') }}">Mina sidor</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
