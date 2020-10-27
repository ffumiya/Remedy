@section('header')
<div class="customize">
    <div class="header row-100 d-flex justify-content-between">
        <div>
            <a href="/home" style="width: 10%;">
                <img class="header-logo" src="{{ asset('img/remedy-pc/logo.png') }}" align=""><br>
            </a>
        </div>
        @if(\Auth::check())
        <div>
            <div class="row-100 d-flex justify-content-between">
                <div>
                    <p class="pt-4" style="color: #006092; font-weight: bold;">
                        <span>
                            {{ \Auth::user()->clinic->name }}
                        </span>
                        <span>
                            {{ \Auth::user()->name }}
                        </span>
                    </p>
                </div>
                <a class="pt-4" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    style="color: #006092; font-weight: bold;">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
