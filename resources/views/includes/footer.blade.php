<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
@if (Request::is('/'))
<script src="{{ asset('js/postal.js') }}"></script>
@elseif (Request::is('sa-funkar-det'))
<script src="{{ asset('js/toggle.js') }}"></script>
@elseif (Request::is('melanders') || Request::is('ulla-winbladh') || Request::is('lidingosaluhall'))
<script src="{{ asset('js/which-bag.js') }}"></script>
<script src="{{ asset('js/hide.js') }}"></script>
@elseif (Request::is('logga-in'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js"></script>
<script src="{{ asset('js/login.js') }}"></script>
@elseif (Request::is('tillaggsprodukter'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js"></script>
<script src="{{ asset('js/addons.js') }}"></script>
@elseif (Request::is('mina-sidor/kommande-leveranser'))
<script src="{{ asset('js/profile.js') }}"></script>
@endif
@if (Request::is('mina-sidor') || Request::is('mina-sidor/alternativa-pasar'))
<script src="{{ asset('js/profileDisabled.js') }}"></script>
@endif
<div class="container" id="footer">
  <div class="footer">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="col-md-4">
          <div class="h3">Kontakt</div>
          <div>
            Telefon: 070 - 12 34 567<br>
            Email:
            <a href="mailto:info@middagskonst.se">
              info@middagskonst.se
            </a>
          </div>
        </div>
        <div class="col-md-5">
          <div class="h3">Meny</div>
          <ul>
            <li>
              <a href="{{ url('/') }}">
                Hem
              </a>
            </li>
            <li>
              <a href="{{ url('/sa-funkar-det') }}">
                Så funkar det
              </a>
            </li>
            @if(Auth::check())
            <li>
              <a href="{{ url('/tillaggsprodukter') }}">
                Tilläggsprodukter
              </a>
            </li>
            @endif
            <li>
              <a href="{{ url('/om-oss') }}">
                Om oss
              </a>
            </li>
            <li>
              <a href="{{ url('/mina-sidor') }}">
                Mina sidor
              </a>
            </li>
            <li><a href="{{ url('/villkor') }}">Villkor
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>
