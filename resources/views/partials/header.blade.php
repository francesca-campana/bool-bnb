<nav class="my-nav navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      @if (Auth::check())
        <a class="navbar-brand" href="{{ url('/admin/apartments') }}">
            <div class="logo">
              <img src="{{asset('images/bool-bnb-rb-02-01.svg')}}" alt="Logo bool bnb">
            </div>
        </a>
        @else
          <a class="navbar-brand" href="{{ url('/') }}">
            <div class="logo">
              <img src="{{asset('images/bool-bnb-rb-02-01.svg')}}" alt="Logo bool bnb">

            </div>
          </a>
      @endif

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item  mr-5">
                      <a class="btn btn-add_app" href="{{ route('admin.apartments.create')}}">Inserisci il tuo appartamento</a>
                    </li>
                    <li class="nav-item dropdown">

                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.user-apartments') }}">
                              I tuoi appartamenti
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.received-emails') }}">
                              Messaggi ricevuti
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                @endguest
            </ul>
        </div>
    </div>
</nav>
