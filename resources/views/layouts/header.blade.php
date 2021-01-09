<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <!-- <div class="container"> -->
        <a class="navbar-brand" href="{{ route('home.index') }}">
            <img class="header-logo" src="{{ asset('img/remedy-pc/logo.png') }}" align="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
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
                <!-- User nav menu -->
                @if (Auth::user()->role >= config('role.doctor.value'))
                @endif

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="mr-2">
                            {{Auth::user()->clinic->name }}
                        </span>
                        <span>
                            {{ Auth::user()->name }}
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="{{ route('survey.index') }}" class="dropdown-item nav-link">
                            患者アンケート一覧
                        </a>
                        <a href="{{ route('manual.index') }}" class="dropdown-item nav-link">
                            ご利用マニュアル
                        </a>
                        <a class="dropdown-item nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    <!-- </div> -->
</nav>
