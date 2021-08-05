<nav x-data="{ open: false }" class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">{{ Auth::user()->name }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <form method="POST" class="navbar-nav form-inline" action="{{ route('logout') }}" id="logout_form">
            @csrf

            <a class="nav-link" href="#" onclick="event.preventDefault(); document.querySelector('#logout_form').submit();">
                {{ __('Log Out') }}
            </a>
        </form>
    </div>
</nav>