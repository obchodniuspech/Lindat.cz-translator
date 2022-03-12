<div class="container">

<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4">
  <a href="{{ route('Překladač') }}" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
    Translator
  </a>

  <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
    <li><a href="{{ route('About') }}" class="nav-link px-2 link-dark">About</a></li>
  </ul>

  <div class="col-md-3 text-end">

    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <!--<a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>-->
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <button type="button" class="btn btn-primary">Odhlášení</button>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">
                    <button type="button" class="btn btn-outline-primary me-2">Přihlásit se</button>
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">
                        <button type="button" class="btn btn-primary">Registrace</button>
                    </a>
                @endif
            @endauth
        </div>
    @endif
  </div>
</header>

</div>
